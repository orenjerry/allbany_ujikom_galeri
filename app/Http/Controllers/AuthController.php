<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (!Session::has('user_id')) {
            return view('auth.login');
        } else {
            return redirect('dashboard');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = Users::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->accepted == 0) {
                return back()
                    ->withErrors(['username' => 'Akun-mu belum diterima. Harap tunggu admin untuk menyetujui akun-mu.'])
                    ->withInput($request->only('username'));
            } elseif ($user->accepted == 'rejected') {
                return back()
                    ->withErrors(['username' => 'Akun-mu ditolak. Harap membuat akun kembali.'])
                    ->withInput($request->only('username'));
            }
            Session::put('user_id', $user->id);
            Session::put('username', $user->username);
            Session::put('email', $user->email);
            Session::put('nama_lengkap', $user->nama_lengkap);
            Session::put('id_role', $user->id_role);

            return redirect('/dashboard')->with('success', 'Login successful!');
        }

        return back()
            ->withErrors(['username' => 'Invalid username or password'])
            ->withInput($request->only('username'));
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:allbany_user,username|min:3',
            'nama_lengkap' => 'required|min:3',
            'email' => 'required|email|unique:allbany_user,email',
            'password' => 'required|min:6'
        ]);

        try {
            $user = Users::create([
                'username' => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => 2,
                'alamat' => $request->address
            ]);

            return redirect('/auth/login')
                ->with('success', 'Registrasi sukses, harap tunggu admin untuk menyetujui akun anda.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Registrasi gagal! Harap coba lagi.']);
        }
    }

    public function doLogout()
    {
        Session::flush();
        Session::save();
        return redirect('/auth/login');
    }
}
