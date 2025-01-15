<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/auth/login');

Route::prefix('/auth')->group(function (){
    Route::get('/login', function() {
        return view('auth.login');
    });
});
