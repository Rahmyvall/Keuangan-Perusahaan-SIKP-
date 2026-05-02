<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;
use App\Models\Pengguna;
use App\Models\MataUang;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // =========================
        // GRAFIK KOTA
        // =========================
        $kotaData = Perusahaan::selectRaw('kota, COUNT(*) as total')
            ->whereNotNull('kota')
            ->where('kota', '!=', '')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->get();

        // =========================
        // DATA PENGGUNA
        // =========================
        $pengguna = Pengguna::with('perusahaan')->get();

        $totalPengguna = Pengguna::count();
        $penggunaAktif = Pengguna::where('is_active', 1)->count();
        $penggunaNonAktif = Pengguna::where('is_active', 0)->count();

        // =========================
        // DATA MATA UANG (BARU)
        // =========================
        $totalMataUang = MataUang::count();

        $mataUangTerbaru = MataUang::latest()
            ->limit(5)
            ->get();

        $mataUangChart = MataUang::select('kode')->get();

        // =========================
        // PREPARE DATA
        // =========================
        $data = [
            'user'  => $user,
            'title' => 'Dashboard',

            // kota chart
            'kota_labels' => $kotaData->pluck('kota')->values(),
            'kota_data'   => $kotaData->pluck('total')->values(),

            // pengguna
            'pengguna' => $pengguna,
            'total_pengguna' => $totalPengguna,
            'pengguna_aktif' => $penggunaAktif,
            'pengguna_nonaktif' => $penggunaNonAktif,

            // mata uang
            'total_mata_uang' => $totalMataUang,
            'mata_uang_terbaru' => $mataUangTerbaru,
            'mata_uang_chart' => $mataUangChart,
        ];

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