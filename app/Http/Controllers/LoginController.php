<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('welcome');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'login' => 'Username atau password salah'
            ])->withInput();
        }

        // regenerasi session (INI WAJIB biar tidak “logout aneh”)
        $request->session()->regenerate();

        $user = Auth::user();

        // mapping role ke dashboard
        $routes = [
            'admin'   => 'admin.dashboard',
            'akuntan' => 'akuntan.dashboard',
            'manajer' => 'manajer.dashboard',
            'auditor' => 'auditor.dashboard',
            'staff'   => 'staff.dashboard',
        ];

        if (!isset($routes[$user->role])) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['login' => 'Role tidak dikenali']);
        }

        return redirect()->route($routes[$user->role]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
