<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Like;
use App\Models\Users;
use App\Models\UsersRejectReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        $filter = $request->query('filter');

        $query = Foto::with('user')
            ->withCount('like', 'komen')
            ->with('like');

        switch ($filter) {
            case 'likes_desc':
                $query->orderBy('like_count', 'desc');
                break;
            case 'likes_asc':
                $query->orderBy('like_count', 'asc');
                break;
            case 'komen_desc':
                $query->orderBy('komen_count', 'desc');
                break;
            case 'komen_asc':
                $query->orderBy('komen_count', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'only_liked':
                $query->whereHas('like', function ($q) {
                    $q->where('id_user', Session::get('user_id'));
                });
                break;
            default:
                $query->inRandomOrder();
                break;
        }

        $foto = $query->get()->map(function ($foto) {
            $foto->is_liked = $foto->like->contains('id_user', Session::get('user_id')) ? true : false;
            return $foto;
        });

        $foto_most_liked = Foto::with('user')
            ->withCount('like')
            ->with('like')
            ->orderBy('like_count', 'desc')
            ->take(6)
            ->get()
            ->map(function ($foto) {
                $foto->is_liked = $foto->like->contains('id_user', Session::get('user_id')) ? true : false;
                return $foto;
            });

        return view('dashboard', compact('foto', 'foto_most_liked'));
    }


    public function showAdminDashboard()
    {
        $users = Users::where('accepted', 'nothing')->get();

        $rejected = Users::where('accepted', 'rejected')
            ->with('rejectionReason')
            ->paginate(5);

        return view('admin.dashboard', compact('users', 'rejected'));
    }

    public function approveUser(Request $request, $id)
    {
        $user = Users::findOrFail($id);
        try {
            if ($request->action == 'approve') {
                $approve = 'accepted';
            } elseif ($request->action == 'reject') {
                $approve = 'rejected';
                $reason = $request->reason;
                UsersRejectReason::create([
                    'id_user' => $id,
                    'reason' => $reason,
                ]);
            }
            $user->update([
                'accepted' => $approve,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update user status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update user status');
        }

        return response()->json(['success' => 1, 'message' => 'User status updated'], 200);
    }

    public function showProfile()
    {
        $user = Users::where('id', Session::get('user_id'))->first();
        return view('profile', compact('user'));
    }

    public function editProfile(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'username' => 'required',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5142',
        ]);

        if (!$validate) {
            return redirect()->back()->withErrors($validate);
        }

        $user = Users::where('id', Session::get('user_id'))->first();
        if ($request->current_password) {
            if (!password_verify($request->current_password, $user->password)) {
                return redirect()->back()->withErrors([
                    'current_password' => 'Password lama salah',
                ]);
            } else {
                $new_password = bcrypt($request->new_password);
            }
        }

        if ($request->hasFile('profile_picture')) {
            $destinationPath = public_path('images/profile/' . $user->id);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $profilePicture = $request->file('profile_picture');
            $profilePictureName = time() . '-' . rand(100, 999) . '.' . $profilePicture->getClientOriginalExtension();

            $profilePicture->move($destinationPath, $profilePictureName);

            $user->foto_profil = 'images/profile/' . $user->id . '/' . $profilePictureName;
        }

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' => $new_password ?? $user->password,
            'foto_profil' => $user->foto_profil,
        ]);

        return redirect()->route('profile');
    }

    public function markAsRead()
    {
        $userId = Session::get('user_id');
        $user = Users::where('id', $userId)->first();

        $user->unreadNotifications->markAsRead();

        return redirect()->back();
    }
}
