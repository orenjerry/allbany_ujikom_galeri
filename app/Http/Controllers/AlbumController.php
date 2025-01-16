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
            $album->cover_image = $album->foto()->inRandomOrder()->first()->lokasi_file;
            return $album;
        });
        return view('album.index', compact('album'));
    }
}
