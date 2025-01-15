<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function showAlbum()
    {
        return view('album.index');
    }
}
