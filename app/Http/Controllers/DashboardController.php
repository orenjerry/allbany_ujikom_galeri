<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $foto = Foto::with('user')->withCount('like')->with('like')->inRandomOrder()->get()->map(function ($foto) {
            $foto->is_liked = $foto->like->contains('id_user', Session::get('user_id')) ? true : false;
            return $foto;
        });
        // dd(Session::get('id'));
        return view('dashboard', compact('foto'));
    }

}
