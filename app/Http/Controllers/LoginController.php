<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('welcome'); // atau login.blade.php
    }
    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|in:admin,akuntan,manajer,auditor,staff',
        ]);

        // ❗ Ambil hanya credential login
        $credentials = $request->only('username', 'password');

        // ✅ Attempt login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            $user = Auth::user();

            // 🔒 Validasi role (lebih aman pakai strict)
            if ($user->role !== $request->input('role')) {
                Auth::logout();

                return back()
                    ->withInput($request->only('username', 'role'))
                    ->withErrors([
                        'role' => 'Role tidak sesuai dengan akun'
                    ]);
            }

            // 🚀 Redirect sesuai role
            return match ($user->role) {
                'admin'   => redirect()->route('admin.dashboard'),
                'akuntan' => redirect()->route('akuntan.dashboard'),
                'manajer' => redirect()->route('manajer.dashboard'),
                'auditor' => redirect()->route('auditor.dashboard'),
                'staff'   => redirect()->route('staff.dashboard'),
                default   => redirect()->route('login'),
            };
        }

        // ❌ Login gagal
        return back()
            ->withInput($request->only('username', 'role'))
            ->withErrors([
                'login' => 'Username atau password salah'
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        // 🔥 invalidate session
        $request->session()->invalidate();

        // 🔥 regenerate token
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Berhasil logout');
    }
}
