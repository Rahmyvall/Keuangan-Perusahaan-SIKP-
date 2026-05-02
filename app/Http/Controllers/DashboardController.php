<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // =========================
        // REDIRECT JIKA TIDAK LOGIN
        // =========================
        if (!$user) {
            return redirect()->route('login');
        }

        // =========================
        // GRAFIK KOTA (SAFE QUERY)
        // =========================
        $kotaData = Perusahaan::selectRaw('kota, COUNT(*) as total')
            ->whereNotNull('kota')
            ->where('kota', '!=', '')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->get();

        // =========================
        // PREPARE DATA (ANTI NULL ERROR)
        // =========================
        $data = [
            'user'  => $user,
            'title' => 'Dashboard',

            'kota_labels' => $kotaData->pluck('kota')->values() ?? collect([]),
            'kota_data'   => $kotaData->pluck('total')->values() ?? collect([]),
        ];

        // =========================
        // ROLE VIEW (SAFE SWITCH)
        // =========================
        $role = $user->role ?? 'admin';

        return match ($role) {
            'admin'   => view('dashboard.admin', $data),
            'akuntan' => view('dashboard.akuntan', $data),
            'manajer' => view('dashboard.manajer', $data),
            'auditor' => view('dashboard.auditor', $data),
            'staff'   => view('dashboard.staff', $data),
            default   => view('dashboard.admin', $data),
        };
    }
}