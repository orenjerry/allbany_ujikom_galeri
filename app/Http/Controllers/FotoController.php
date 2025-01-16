<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use App\Models\Komen;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FotoController extends Controller
{
    public function showDetailFoto($id)
    {
        $foto = Foto::where('id', $id)->with('user')->withCount('like')->with('like')->withCount('komen')->with('komen')->first();
        // dd($foto);
        $foto->is_liked = $foto->like->contains('id_user', Session::get('user_id')) ? true : false;

        return view('foto.index', compact('foto'));
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
            'lokasi_file' => 'images/'.$fileName,
            'judul_foto' => $request->judul,
            'deskripsi_foto' => $request->deskripsi
        ]);

        return redirect()->route('dashboard');
    }

    public function toggleLike($id)
    {
        $userId = Session::get('user_id');

        $existingLike = Like::where('id_foto', $id)->where('id_user', $userId)->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Like::create([
                'id_foto' => $id,
                'id_user' => $userId
            ]);
        }

        return redirect()->back();
    }

    public function addComment(Request $request, $id)
    {
        $userId = Session::get('user_id');

        Komen::create([
            'id_foto' => $id,
            'id_user' => $userId,
            'isi_komentar' => $request->komentar
        ]);

        return redirect()->back();
    }
}
