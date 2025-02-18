<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use App\Models\Komen;
use App\Models\Like;
use App\Models\User;
use App\Models\Users;
use App\Notifications\Notif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class FotoController extends Controller
{
    public function showDetailFoto($id)
    {
        $foto = Foto::where('id', $id)->with('user')->withCount('like')->withCount('komen')->with('komen')->first();
        if (!$foto) {
            return redirect()->route('dashboard');
        }
        // dd($foto);
        $foto->is_liked = $foto->like->contains('id_user', Session::get('user_id')) ? true : false;

        $album = Album::where('id_user', Session::get('user_id'))->get();

        return view('foto.index', compact(['foto', 'album']));
    }

    public function showAddFoto()
    {
        $album = Album::where('id_user', Session::get('user_id'))->get();
        return view('foto.addFoto', compact('album'));
    }

    public function addFoto(Request $request)
    {
        $validate = $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'judul' => 'required',
            'deskripsi' => 'required',
            'album' => 'required'
        ]);

        if (!$validate) {
            return redirect()->back()->withErrors($validate);
        }

        $userId = Session::get('user_id');

        $file = $request->file('file');
        $fileName = str()->random(19) . '.' . $file->getClientOriginalExtension();
        $file->move('images', $fileName);

        Foto::create([
            'id_user' => $userId,
            'id_album' => $request->album,
            'lokasi_file' => 'images/' . $fileName,
            'judul_foto' => $request->judul,
            'deskripsi_foto' => $request->deskripsi
        ]);

        return redirect()->route('dashboard');
    }

    public function toggleLike($id)
    {
        $userId = Session::get('user_id');
        $user = Users::where('id', $userId)->first();

        $existingLike = Like::where('id_foto', $id)->where('id_user', $userId)->get();

        if ($existingLike->count() > 0) {
            foreach ($existingLike as $like) {
                $like->delete();
            }
            DB::table('notifications')
                ->where('data->id_user', $userId)
                ->where('data->id_foto', $id)
                ->delete();
        } else {
            Like::create([
                'id_foto' => $id,
                'id_user' => $userId
            ]);
            $foto_owner_id = Foto::where('id', $id)->first()->id_user;
            if (Session::get('user_id') != $foto_owner_id) {
                Users::find($foto_owner_id)->notify(new Notif('like', $user->nama_lengkap . ' menyukai foto anda', $userId, $id));
            }
        }

        return redirect()->back();
    }

    public function addComment(Request $request, $id)
    {
        $userId = Session::get('user_id');
        $user = Users::where('id', $userId)->first();

        Komen::create([
            'id_foto' => $id,
            'id_user' => $userId,
            'isi_komentar' => $request->komentar
        ]);
        $foto_owner_id = Foto::where('id', $id)->first()->id_user;
        if (Session::get('user_id') != $foto_owner_id) {
            Users::find(Foto::where('id', $id)->first()->id_user)->notify(new Notif(aksi: 'comment', isi: $user->nama_lengkap . ' menkomentari foto anda', id_user: $userId, id_foto: $id));
        }

        return redirect()->back();
    }

    public function editFoto(Request $request, $id)
    {
        $foto = Foto::where('id', $id)->first();

        $validate = $request->validate([
            'judul_foto' => 'required',
            'deskripsi_foto' => 'required',
            'album' => 'required'
        ]);

        if (!$validate) {
            return redirect()->back()->withErrors($validate);
        }

        $foto->update([
            'judul_foto' => $request->judul_foto,
            'deskripsi_foto' => $request->deskripsi_foto,
            'id_album' => $request->album
        ]);

        return redirect()->back();
    }

    public function deleteFoto(Request $request, $id)
    {
        if (Session::get('id_role') == 1 || Foto::where('id', $id)->first()->id_user == Session::get('user_id')) {
            $foto = Foto::where('id', $id)->first();
            $komen = Komen::where('id_foto', $id)->get();
            $like = Like::where('id_foto', $id)->get();

            try {
                if (Session::get('id_role') == 1) {
                    $user = Users::where('id', $foto->id_user)->first();
                    $user->notify(new Notif('delete', 'Foto berjudul "' . $foto->judul_foto . '" telah dihapus oleh admin karena ' . $request->reason, $foto->id_user, $id));
                }
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Gagal menghapus foto']);
            }

            $lokasi_foto = $foto->lokasi_file;
            unlink(public_path($lokasi_foto));

            $komen->each->delete();
            $like->each->delete();
            $foto->delete();

            return redirect()->route('dashboard');
        }
    }
}
