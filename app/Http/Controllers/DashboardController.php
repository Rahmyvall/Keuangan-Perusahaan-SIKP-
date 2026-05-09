<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;
use App\Models\Pengguna;
use App\Models\MataUang;
use App\Models\Akun;
use App\Models\Supplier;
use App\Models\FakturPenjualan;
use App\Models\PenerimaanPiutang;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

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
        // DATA MATA UANG
        // =============================================
        $totalMataUang = MataUang::count();

        $mataUangTerbaru = MataUang::latestData()
            ->limit(5)
            ->get();

        // =============================================
        // DATA AKUN
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
        // DATA PERUSAHAAN
        // =============================================
        $totalPerusahaan = Perusahaan::count();

        // =============================================
        // DATA SUPPLIER
        // =============================================
        $totalSupplier = Supplier::count();

        $supplierTerbaru = Supplier::with('perusahaan')
            ->latest('id_supplier')
            ->limit(5)
            ->get();

        $supplierPerusahaan = Supplier::selectRaw('id_perusahaan, COUNT(*) as total')
            ->with('perusahaan')
            ->groupBy('id_perusahaan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // =============================================
        // DATA FAKTUR PENJUALAN
        // =============================================
        $totalEarnings = 0;
        $earningsBulanIni = 0;
        $growthEarnings = 0;

        $totalTransaksi = 0;
        $growthTransaksi = 0;
        $transaksiPending = 0;

        if ($idPerusahaan) {

            $fakturQuery = FakturPenjualan::where('id_perusahaan', $idPerusahaan);

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
                ->whereBetween('tanggal', [
                    now()->subDays(14),
                    now()->subDays(7)
                ])
                ->sum('total');

            $growthEarnings = $earningsMingguLalu > 0
                ? round((($earningsMingguIni - $earningsMingguLalu) / $earningsMingguLalu) * 100, 2)
                : 0;

            $totalTransaksi = $fakturQuery->clone()->count();

            $transaksiMingguIni = $fakturQuery->clone()
                ->where('tanggal', '>=', now()->subDays(7))
                ->count();

            $transaksiMingguLalu = $fakturQuery->clone()
                ->whereBetween('tanggal', [
                    now()->subDays(14),
                    now()->subDays(7)
                ])
                ->count();

            $growthTransaksi = $transaksiMingguLalu > 0
                ? round((($transaksiMingguIni - $transaksiMingguLalu) / $transaksiMingguLalu) * 100, 2)
                : 0;

            $transaksiPending = $fakturQuery->clone()
                ->where('status', 'Belum Lunas')
                ->count();
        }

        // =============================================
        // DATA PENERIMAAN PIUTANG
        // =============================================
        $totalPenerimaan = 0;
        $penerimaanHariIni = 0;
        $penerimaanBulanIni = 0;
        $totalTransaksiPenerimaan = 0;

        $growthHariIni = 0;
        $growthBulanIni = 0;

        if ($idPerusahaan) {

            $penerimaanQuery = PenerimaanPiutang::where('id_perusahaan', $idPerusahaan);

            $totalPenerimaan = $penerimaanQuery->clone()->sum('jumlah');

            $totalTransaksiPenerimaan = $penerimaanQuery->clone()->count();

            // Hari Ini
            $penerimaanHariIni = $penerimaanQuery->clone()
                ->whereDate('tanggal', now()->format('Y-m-d'))
                ->sum('jumlah');

            $penerimaanKemarin = $penerimaanQuery->clone()
                ->whereDate('tanggal', now()->subDay()->format('Y-m-d'))
                ->sum('jumlah');

            $growthHariIni = $penerimaanKemarin > 0
                ? round((($penerimaanHariIni - $penerimaanKemarin) / $penerimaanKemarin) * 100, 2)
                : 0;

            // Bulan Ini
            $penerimaanBulanIni = $penerimaanQuery->clone()
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('jumlah');

            $penerimaanBulanLalu = $penerimaanQuery->clone()
                ->whereMonth('tanggal', now()->subMonth()->month)
                ->whereYear('tanggal', now()->subMonth()->year)
                ->sum('jumlah');

            $growthBulanIni = $penerimaanBulanLalu > 0
                ? round((($penerimaanBulanIni - $penerimaanBulanLalu) / $penerimaanBulanLalu) * 100, 2)
                : 0;
        }

        // =============================================
        // KIRIM DATA KE VIEW
        // =============================================
        $data = [

            'user' => $user,
            'title' => 'Dashboard',

            // Perusahaan
            'total_perusahaan' => $totalPerusahaan,
            'kota_labels' => $kotaData->pluck('kota'),
            'kota_data' => $kotaData->pluck('total'),

            // Pengguna
            'pengguna' => $pengguna,
            'total_pengguna' => $totalPengguna,
            'pengguna_aktif' => $penggunaAktif,
            'pengguna_nonaktif' => $penggunaNonAktif,

            // Mata Uang
            'total_mata_uang' => $totalMataUang,
            'mata_uang_terbaru' => $mataUangTerbaru,

            // Akun
            'akun_chart' => $akunChart,
            'total_akun' => $totalAkun,

            // Supplier
            'total_supplier' => $totalSupplier,
            'supplier_terbaru' => $supplierTerbaru,
            'supplier_perusahaan' => $supplierPerusahaan,

            // Faktur Penjualan
            'total_earnings' => $totalEarnings,
            'earnings_bulan_ini' => $earningsBulanIni,
            'growth_earnings' => $growthEarnings,
            'total_transaksi' => $totalTransaksi,
            'growth_transaksi' => $growthTransaksi,
            'transaksi_pending' => $transaksiPending,

            // Penerimaan Piutang
            'total_penerimaan' => $totalPenerimaan,
            'penerimaan_hari_ini' => $penerimaanHariIni,
            'penerimaan_bulan_ini' => $penerimaanBulanIni,
            'total_transaksi_penerimaan' => $totalTransaksiPenerimaan,
            'growth_hari_ini' => $growthHariIni,
            'growth_bulan_ini' => $growthBulanIni,
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
