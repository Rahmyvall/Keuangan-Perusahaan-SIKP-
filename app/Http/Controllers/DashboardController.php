<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Perusahaan;
use App\Models\Pengguna;
use App\Models\Akun;
use App\Models\Supplier;
use App\Models\FakturPenjualan;
use App\Models\FakturPembelian;
use App\Models\PenerimaanPiutang;
use App\Models\Depresiasi;
use App\Models\RekeningBank;

class DashboardController extends Controller
{
   public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |------------------------------------------------------------------
        | ID PERUSAHAAN
        |------------------------------------------------------------------
        */
        $idPerusahaan =
            $user->id_perusahaan
            ?? $user->perusahaan_id
            ?? optional($user->perusahaan)->id_perusahaan
            ?? null;

        /*
        |------------------------------------------------------------------
        | CHART DEFAULT
        |------------------------------------------------------------------
        */
        $chartBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $chartTotal = array_fill(0, 12, 0);

        $depresiasiBulan = $chartBulan;
        $depresiasiTotal = array_fill(0, 12, 0);

        /*
        |------------------------------------------------------------------
        | DEFAULT VALUE (SAFE)
        |------------------------------------------------------------------
        */
        $totalEarnings = 0;
        $earningsBulanIni = 0;
        $growthEarnings = 0;

        $totalTransaksi = 0;
        $growthTransaksi = 0;
        $transaksiPending = 0;

        $totalPenerimaan = 0;
        $penerimaanHariIni = 0;
        $penerimaanBulanIni = 0;
        $growthHariIni = 0;
        $growthBulanIni = 0;
        $totalTransaksiPenerimaan = 0;

        /*
        |------------------------------------------------------------------
        | REKENING BANK DEFAULT (FIX ERROR UTAMA)
        |------------------------------------------------------------------
        */
        $totalRekeningBank = 0;
        $rekeningBankAktif = 0;
        $rekeningBankNonAktif = 0;
        $rekeningBank = collect();

        /*
        |------------------------------------------------------------------
        | GLOBAL DATA
        |------------------------------------------------------------------
        */
        $totalPerusahaan = Perusahaan::count();

        $kotaData = Perusahaan::selectRaw('kota, COUNT(*) as total')
            ->whereNotNull('kota')
            ->where('kota', '!=', '')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $totalPengguna = Pengguna::count();
        $penggunaAktif = Pengguna::where('is_active', 1)->count();
        $penggunaNonAktif = $totalPengguna - $penggunaAktif;

        $pengguna = Pengguna::with('perusahaan')
            ->latest()
            ->limit(8)
            ->get();

        $akunData = Akun::selectRaw('tipe_akun, COUNT(*) as total')
            ->groupBy('tipe_akun')
            ->pluck('total', 'tipe_akun');

        $akunChart = [
            'Aset' => $akunData['Aset'] ?? 0,
            'Liabilitas' => $akunData['Liabilitas'] ?? 0,
            'Ekuitas' => $akunData['Ekuitas'] ?? 0,
            'Pendapatan' => $akunData['Pendapatan'] ?? 0,
            'Beban' => $akunData['Beban'] ?? 0,
        ];

        $totalAkun = Akun::count();

        $totalSupplier = Supplier::count();

        $supplierTerbaru = Supplier::with('perusahaan')
            ->latest('id_supplier')
            ->limit(5)
            ->get();

        $totalDepresiasi = Depresiasi::sum('nilai_depresiasi');

        /*
        |------------------------------------------------------------------
        | PER PERUSAHAAN
        |------------------------------------------------------------------
        */
        if ($idPerusahaan) {

            // PENJUALAN
            $penjualan = FakturPenjualan::where('id_perusahaan', $idPerusahaan);

            $totalEarnings = (clone $penjualan)->where('status', 'Lunas')->sum('total');

            $earningsBulanIni = (clone $penjualan)
                ->where('status', 'Lunas')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('total');

            $bulanLalu = (clone $penjualan)
                ->where('status', 'Lunas')
                ->whereMonth('tanggal', now()->subMonth()->month)
                ->whereYear('tanggal', now()->subMonth()->year)
                ->sum('total');

            if ($bulanLalu > 0) {
                $growthEarnings = (($earningsBulanIni - $bulanLalu) / $bulanLalu) * 100;
            }

            $totalTransaksi = (clone $penjualan)->count();

            $transaksiPending = (clone $penjualan)
                ->where('status', 'Belum Lunas')
                ->count();

            // PEMBELIAN
            $pembelian = FakturPembelian::where('id_perusahaan', $idPerusahaan);

            $chartData = (clone $pembelian)
                ->selectRaw('MONTH(tanggal) as bulan, SUM(total) as total')
                ->whereYear('tanggal', now()->year)
                ->groupBy(DB::raw('MONTH(tanggal)'))
                ->get();

            foreach ($chartData as $item) {
                $chartTotal[$item->bulan - 1] = (float) $item->total;
            }

            // DEPRESIASI
            $chartDepresiasi = Depresiasi::selectRaw('MONTH(periode_depresiasi) as bulan, SUM(nilai_depresiasi) as total')
                ->whereYear('periode_depresiasi', now()->year)
                ->groupBy(DB::raw('MONTH(periode_depresiasi)'))
                ->get();

            foreach ($chartDepresiasi as $item) {
                $depresiasiTotal[$item->bulan - 1] = (float) $item->total;
            }

            // PENERIMAAN
            $penerimaan = PenerimaanPiutang::where('id_perusahaan', $idPerusahaan);

            $totalPenerimaan = (clone $penerimaan)->sum('jumlah');

            $totalTransaksiPenerimaan = (clone $penerimaan)->count();

            $penerimaanHariIni = (clone $penerimaan)
                ->whereDate('tanggal', today())
                ->sum('jumlah');

            $kemarin = (clone $penerimaan)
                ->whereDate('tanggal', today()->subDay())
                ->sum('jumlah');

            if ($kemarin > 0) {
                $growthHariIni = (($penerimaanHariIni - $kemarin) / $kemarin) * 100;
            }

            $penerimaanBulanIni = (clone $penerimaan)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('jumlah');

            $bulanLaluPenerimaan = (clone $penerimaan)
                ->whereMonth('tanggal', now()->subMonth()->month)
                ->whereYear('tanggal', now()->subMonth()->year)
                ->sum('jumlah');

            if ($bulanLaluPenerimaan > 0) {
                $growthBulanIni = (($penerimaanBulanIni - $bulanLaluPenerimaan) / $bulanLaluPenerimaan) * 100;
            }

            // 🔥 REKENING BANK (FIX FINAL)
            $totalRekeningBank = RekeningBank::where('id_perusahaan', $idPerusahaan)->count();

            $rekeningBankAktif = RekeningBank::where('id_perusahaan', $idPerusahaan)
                ->where('is_active', 1)
                ->count();

            $rekeningBankNonAktif = RekeningBank::where('id_perusahaan', $idPerusahaan)
                ->where('is_active', 0)
                ->count();

            $rekeningBank = RekeningBank::where('id_perusahaan', $idPerusahaan)
                ->latest()
                ->limit(5)
                ->get();
        }

        /*
        |------------------------------------------------------------------
        | VIEW DATA
        |------------------------------------------------------------------
        */
        $data = [
            'user' => $user,
            'title' => 'Dashboard',

            'total_perusahaan' => $totalPerusahaan,
            'kota_labels' => $kotaData->pluck('kota'),
            'kota_data' => $kotaData->pluck('total'),

            'total_pengguna' => $totalPengguna,
            'pengguna_aktif' => $penggunaAktif,
            'pengguna_nonaktif' => $penggunaNonAktif,
            'pengguna' => $pengguna,

            'akun_chart' => $akunChart,
            'total_akun' => $totalAkun,

            'total_supplier' => $totalSupplier,
            'supplier_terbaru' => $supplierTerbaru,

            'total_earnings' => $totalEarnings,
            'earnings_bulan_ini' => $earningsBulanIni,
            'growth_earnings' => round($growthEarnings, 2),

            'total_transaksi' => $totalTransaksi,
            'growth_transaksi' => round($growthTransaksi, 2),
            'transaksi_pending' => $transaksiPending,

            'chart_bulan' => $chartBulan,
            'chart_total' => $chartTotal,

            'total_depresiasi' => $totalDepresiasi,
            'depresiasi_bulan' => $depresiasiBulan,
            'depresiasi_total' => $depresiasiTotal,

            'total_penerimaan' => $totalPenerimaan,
            'total_transaksi_penerimaan' => $totalTransaksiPenerimaan,
            'penerimaan_hari_ini' => $penerimaanHariIni,
            'penerimaan_bulan_ini' => $penerimaanBulanIni,
            'growth_hari_ini' => round($growthHariIni, 2),
            'growth_bulan_ini' => round($growthBulanIni, 2),

            // 🔥 REKENING BANK FINAL FIX
            'total_rekening_bank' => $totalRekeningBank,
            'rekening_aktif' => $rekeningBankAktif,
            'rekening_nonaktif' => $rekeningBankNonAktif,
            'rekening_bank' => $rekeningBank,
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
