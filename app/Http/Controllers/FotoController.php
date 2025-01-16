<?php

namespace App\Http\Controllers;

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
