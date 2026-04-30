<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * DASHBOARD BERDASARKAN ROLE
     */
    public function index()
    {
        $user = Auth::user();

        // 🔒 kalau belum login
        if (!$user) {
            return redirect()->route('login');
        }

        $data = [
            'user' => $user
        ];

        // 🔥 tampilkan view sesuai role
        switch ($user->role) {
            case 'admin':
                return view('dashboard.admin', $data + ['title' => 'Dashboard Admin']);

            case 'akuntan':
                return view('dashboard.akuntan', $data + ['title' => 'Dashboard Akuntan']);

            case 'manajer':
                return view('dashboard.manajer', $data + ['title' => 'Dashboard Manajer']);

            case 'auditor':
                return view('dashboard.auditor', $data + ['title' => 'Dashboard Auditor']);

            case 'staff':
                return view('dashboard.staff', $data + ['title' => 'Dashboard Staff']);

            default:
                abort(403, 'Role tidak dikenali');
        }
    }
}
