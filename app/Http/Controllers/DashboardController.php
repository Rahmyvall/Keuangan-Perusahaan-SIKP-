<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;
use App\Models\Pengguna;
use App\Models\MataUang;
use App\Models\Akun;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect jika belum login
        if (!$user) {
            return redirect()->route('login');
        }

        // =============================================
        // DATA KOTA PERUSAHAAN
        // =============================================
        $kotaData = Perusahaan::selectRaw('kota, COUNT(*) as total')
            ->whereNotNull('kota')
            ->where('kota', '!=', '')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->limit(10)                    // batasi agar chart tidak terlalu penuh
            ->get();

        // =============================================
        // DATA PENGGUNA
        // =============================================
        $totalPengguna = Pengguna::count();
        $penggunaAktif = Pengguna::where('is_active', true)->count();
        $penggunaNonAktif = $totalPengguna - $penggunaAktif;

        // Load pengguna dengan perusahaan (untuk tabel jika diperlukan)
        $pengguna = Pengguna::with('perusahaan')
            ->latest()
            ->limit(8)
            ->get();

        // =============================================
        // DATA MATA UANG
        // =============================================
        $totalMataUang = MataUang::count();
        $mataUangTerbaru = MataUang::latest()->limit(5)->get();

        // =============================================
        // DATA AKUN (Chart of Account)
        // =============================================
        $akunData = Akun::selectRaw('tipe_akun, COUNT(*) as total')
            ->where('is_active', true)
            ->groupBy('tipe_akun')
            ->pluck('total', 'tipe_akun');

        $akunChart = [
            'Aset'       => $akunData['Aset']       ?? 0,
            'Liabilitas' => $akunData['Liabilitas'] ?? 0,
            'Ekuitas'    => $akunData['Ekuitas']    ?? 0,
            'Pendapatan' => $akunData['Pendapatan'] ?? 0,
            'Beban'      => $akunData['Beban']      ?? 0,
        ];

        $totalAkun = Akun::where('is_active', true)->count();

        // =============================================
        // TOTAL PERUSAHAAN (Tambahan yang berguna)
        // =============================================
        $totalPerusahaan = Perusahaan::count();

        // =============================================
        // KIRIM DATA KE VIEW
        // =============================================
        $data = [
            'user'                  => $user,
            'title'                 => 'Dashboard',

            // Perusahaan & Kota
            'total_perusahaan'      => $totalPerusahaan,
            'kota_labels'           => $kotaData->pluck('kota'),
            'kota_data'             => $kotaData->pluck('total'),

            // Pengguna
            'pengguna'              => $pengguna,
            'total_pengguna'        => $totalPengguna,
            'pengguna_aktif'        => $penggunaAktif,
            'pengguna_nonaktif'     => $penggunaNonAktif,

            // Mata Uang
            'total_mata_uang'       => $totalMataUang,
            'mata_uang_terbaru'     => $mataUangTerbaru,

            // Akun
            'akun_chart'            => $akunChart,
            'total_akun'            => $totalAkun,
        ];

        // Redirect berdasarkan role
        return match ($user->role) {
            'admin'   => view('dashboard.admin', $data),
            'akuntan' => view('dashboard.akuntan', $data),
            'manajer' => view('dashboard.manajer', $data),
            'auditor' => view('dashboard.auditor', $data),
            'staff'   => view('dashboard.staff', $data),
            default   => view('dashboard.admin', $data),
        };
    }
}
