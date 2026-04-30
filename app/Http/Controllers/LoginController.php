<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role' => 'required|in:admin,akuntan,manajer,auditor,staff'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            $user = Auth::user();

            // 🔒 Validasi role
            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->with('error', 'Role tidak sesuai');
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

        return back()->with('error', 'Username atau password salah');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        // 🔥 logout user
        Auth::logout();

        // 🔥 hapus session lama
        $request->session()->invalidate();

        // 🔥 regenerate CSRF token (WAJIB)
        $request->session()->regenerateToken();

        // 🔥 redirect ke login
        return redirect()->route('login')
            ->with('success', 'Berhasil logout');
    }
}