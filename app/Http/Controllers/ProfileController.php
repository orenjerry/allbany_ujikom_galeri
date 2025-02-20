<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
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

    public function insight()
    {
        $user = Users::where('id', Session::get('user_id'))->first();

        $fotos = Foto::with(['like', 'komen'])
            ->where('id_user', Session::get('user_id'))
            ->get();

        $totalLikes = 0;
        $totalComments = 0;

        foreach ($fotos as $foto) {
            $totalLikes += $foto->like->count();
            $totalComments += $foto->komen->count();
        }

        $topLikedPhotos = Foto::with('like')
            ->where('id_user', Session::get('user_id'))
            ->withCount('like')
            ->orderBy('like_count', 'desc')
            ->take(5)
            ->get();

        $topCommentedPhotos = Foto::with('komen')
            ->where('id_user', Session::get('user_id'))
            ->withCount('komen')
            ->orderBy('komen_count', 'desc')
            ->take(5)
            ->get();

        $topInteractors = Users::join('allbany_foto_like', function ($join) {
            $join->on('allbany_user.id', '=', 'allbany_foto_like.id_user');
        })
            ->join('allbany_foto', function ($join) {
                $join->on('allbany_foto.id', '=', 'allbany_foto_like.id_foto')
                    ->whereColumn('allbany_foto.id_user', '!=', 'allbany_foto_like.id_user');
            })
            ->leftJoin('allbany_foto_komentar', function ($join) {
                $join->on('allbany_user.id', '=', 'allbany_foto_komentar.id_user')
                    ->whereColumn('allbany_foto_komentar.id_user', '!=', 'allbany_foto.id_user');
            })
            ->where('allbany_foto.id_user', Session::get('user_id'))
            ->select(
                'allbany_user.id',
                'allbany_user.username',
                'allbany_user.foto_profil'
            )
            ->selectRaw('COUNT(DISTINCT allbany_foto_like.id) as total_like')
            ->selectRaw('COUNT(DISTINCT allbany_foto_komentar.id) as total_komen')
            ->groupBy('allbany_user.id', 'allbany_user.username', 'allbany_user.foto_profil')
            ->orderByRaw('(COUNT(DISTINCT allbany_foto_like.id) + COUNT(DISTINCT allbany_foto_komentar.id)) DESC')
            ->take(5)
            ->get();
        // dd($topInteractors);

        return view('profile.insight', compact(
            'user',
            'fotos',
            'totalLikes',
            'totalComments',
            'topLikedPhotos',
            'topCommentedPhotos',
            'topInteractors'
        ));
    }
}
