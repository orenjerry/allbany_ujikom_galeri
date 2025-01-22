<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AlbumController extends Controller
{
    public function showAlbum()
    {
        $album = Album::where('id_user', Session::get('user_id'))->with('foto')->get()->map(function ($album) {
            $firstFoto = $album->foto()->inRandomOrder()->first();
            $album->cover_image = $firstFoto ? $firstFoto->lokasi_file : 'assets/images/default_images/default_album.png';
            return $album;
        });
        return view('album.index', compact('album'));
    }

    public function showDetailAlbum($id)
    {
        $album = Album::where('id', $id)->with('user')->first();
        $album->foto->map(function ($foto) {
            $foto->is_liked = $foto->like->contains('id_user', Session::get('user_id')) ? true : false;
            $foto->like_count = $foto->like->count();
            return $foto;
        });
        if ($album->id_user != Session::get('user_id')) {
            return redirect()->route('album');
        }
        return view('album.detailAlbum', compact('album'));
    }

    public function showCreateAlbum()
    {
        return view('album.createAlbum');
    }

    public function createAlbum()
    {
        $validate = request()->validate([
            'nama_album' => 'required',
            'deskripsi' => 'required',
        ]);

        if (!$validate) {
            return redirect()->back()->withErrors($validate);
        }

        // Check if nama album is exist :D
        $album = Album::where('nama_album', request('nama_album'))->first();
        if ($album) {
            return redirect()->back()->withErrors([
                'nama_album' => 'Nama album sudah ada',
            ]);
        }

        Album::create([
            'id_user' => Session::get('user_id'),
            'nama_album' => request('nama_album'),
            'deskripsi' => request('deskripsi'),
        ]);

        return redirect()->route('album');
    }
}
