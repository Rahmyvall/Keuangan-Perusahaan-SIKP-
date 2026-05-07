<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;
use App\Models\Pengguna;
use App\Models\MataUang;
use App\Models\Akun;
use App\Models\FakturPenjualan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil ID Perusahaan dengan aman
        $idPerusahaan = $user->id_perusahaan
                     ?? $user->perusahaan_id
                     ?? $user->perusahaan?->id_perusahaan
                     ?? null;

        // =============================================
        // DATA KOTA PERUSAHAAN
        // =============================================
        $kotaData = Perusahaan::selectRaw('kota, COUNT(*) as total')
            ->whereNotNull('kota')
            ->where('kota', '!=', '')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // =============================================
        // DATA PENGGUNA
        // =============================================
        $totalPengguna = Pengguna::count();
        $penggunaAktif = Pengguna::where('is_active', true)->count();
        $penggunaNonAktif = $totalPengguna - $penggunaAktif;

        $pengguna = Pengguna::with('perusahaan')
            ->latest()
            ->limit(8)
            ->get();

        // =============================================
        // DATA MATA UANG & AKUN
        // =============================================
        $totalMataUang = MataUang::count();
        $mataUangTerbaru = MataUang::latestData()->limit(5)->get();

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
        $totalPerusahaan = Perusahaan::count();

        // =============================================
        // DATA FAKTUR PENJUALAN (Earnings + Transaksi)
        // =============================================
        $totalEarnings = 0;
        $earningsBulanIni = 0;
        $growthEarnings = 0;
        $totalTransaksi = 0;
        $growthTransaksi = 0;
        $transaksiPending = 0;

        if ($idPerusahaan) {
            $fakturQuery = FakturPenjualan::where('id_perusahaan', $idPerusahaan);

            // === EARNINGS ===
            $totalEarnings = $fakturQuery->clone()
                ->where('status', 'Lunas')
                ->sum('total');

            $earningsBulanIni = $fakturQuery->clone()
                ->where('status', 'Lunas')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('total');

            $earningsMingguIni = $fakturQuery->clone()
                ->where('status', 'Lunas')
                ->where('tanggal', '>=', now()->subDays(7))
                ->sum('total');

            $earningsMingguLalu = $fakturQuery->clone()
                ->where('status', 'Lunas')
                ->whereBetween('tanggal', [now()->subDays(14), now()->subDays(7)])
                ->sum('total');

            $growthEarnings = $earningsMingguLalu > 0
                ? round((($earningsMingguIni - $earningsMingguLalu) / $earningsMingguLalu) * 100, 2)
                : 0;

            // === TRANSAKSI ===
            $totalTransaksi = $fakturQuery->clone()->count();

            $transaksiMingguIni = $fakturQuery->clone()
                ->where('tanggal', '>=', now()->subDays(7))
                ->count();

            $transaksiMingguLalu = $fakturQuery->clone()
                ->whereBetween('tanggal', [now()->subDays(14), now()->subDays(7)])
                ->count();

            $growthTransaksi = $transaksiMingguLalu > 0
                ? round((($transaksiMingguIni - $transaksiMingguLalu) / $transaksiMingguLalu) * 100, 2)
                : 0;

            // Pending
            $transaksiPending = $fakturQuery->clone()
                ->where('status', 'Belum Lunas')
                ->count();
        }

        // =============================================
        // KIRIM DATA KE VIEW
        // =============================================
        $data = [
            'user'                  => $user,
            'title'                 => 'Dashboard',

            // Perusahaan
            'total_perusahaan'      => $totalPerusahaan,
            'kota_labels'           => $kotaData->pluck('kota'),
            'kota_data'             => $kotaData->pluck('total'),

            // Pengguna
            'pengguna'              => $pengguna,
            'total_pengguna'        => $totalPengguna,
            'pengguna_aktif'        => $penggunaAktif,
            'pengguna_nonaktif'     => $penggunaNonAktif,

            // Mata Uang & Akun
            'total_mata_uang'       => $totalMataUang,
            'mata_uang_terbaru'     => $mataUangTerbaru,
            'akun_chart'            => $akunChart,
            'total_akun'            => $totalAkun,

            // Faktur Penjualan
            'total_earnings'        => $totalEarnings,
            'earnings_bulan_ini'    => $earningsBulanIni,
            'growth_earnings'       => $growthEarnings,

            'total_transaksi'       => $totalTransaksi,
            'growth_transaksi'      => $growthTransaksi,     // ← Ditambahkan
            'transaksi_pending'     => $transaksiPending,
        ];

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
