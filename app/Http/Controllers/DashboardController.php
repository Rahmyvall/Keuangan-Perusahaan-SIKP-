<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;
use App\Models\Pengguna;

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
        // DATA PENGGUNA (BARU DITAMBAHKAN)
        // =========================
        $pengguna = Pengguna::with('perusahaan')->get();

        $totalPengguna = Pengguna::count();
        $penggunaAktif = Pengguna::where('is_active', 1)->count();
        $penggunaNonAktif = Pengguna::where('is_active', 0)->count();

        // =========================
        // PREPARE DATA
        // =========================
        $data = [
            'user'  => $user,
            'title' => 'Dashboard',

            // kota chart
            'kota_labels' => $kotaData->pluck('kota')->values() ?? collect([]),
            'kota_data'   => $kotaData->pluck('total')->values() ?? collect([]),

            // pengguna (BARU)
            'pengguna' => $pengguna,
            'total_pengguna' => $totalPengguna,
            'pengguna_aktif' => $penggunaAktif,
            'pengguna_nonaktif' => $penggunaNonAktif,
        ];

        // =========================
        // ROLE VIEW
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
