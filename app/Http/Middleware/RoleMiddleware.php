<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // wajib login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // safety check kalau role kosong
        if (!$user || empty($user->role)) {
            abort(403, 'Role tidak ditemukan');
        }

        // cek role
        if (!in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
