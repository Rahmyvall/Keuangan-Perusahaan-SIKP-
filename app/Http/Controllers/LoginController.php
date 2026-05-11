<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');   // pastikan file ada di: resources/views/auth/login.blade.php
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|in:admin,akuntan,manajer,auditor,staff',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Perbaikan di sini
            if (auth()->user()->role === $request->role) {
                return redirect()->intended('/dashboard');
            } else {
                Auth::logout();
                return back()->with('error', 'Role yang dipilih tidak sesuai dengan akun Anda.');
            }
        }

        return back()->with('error', 'Username atau password salah.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}