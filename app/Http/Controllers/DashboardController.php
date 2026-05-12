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

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | ID PERUSAHAAN
        |--------------------------------------------------------------------------
        */

        $idPerusahaan =
            $user->id_perusahaan
            ?? $user->perusahaan_id
            ?? optional($user->perusahaan)->id_perusahaan
            ?? null;

        /*
        |--------------------------------------------------------------------------
        | DEFAULT CHART
        |--------------------------------------------------------------------------
        */

        $chartBulan = [
            'Jan', 'Feb', 'Mar', 'Apr',
            'Mei', 'Jun', 'Jul', 'Agu',
            'Sep', 'Okt', 'Nov', 'Des'
        ];

        $chartTotal = array_fill(0, 12, 0);

        /*
        |--------------------------------------------------------------------------
        | DATA PERUSAHAAN
        |--------------------------------------------------------------------------
        */

        $kotaData = Perusahaan::query()
            ->selectRaw('kota, COUNT(*) as total')
            ->whereNotNull('kota')
            ->where('kota', '!=', '')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $totalPerusahaan = Perusahaan::count();

        /*
        |--------------------------------------------------------------------------
        | DATA PENGGUNA
        |--------------------------------------------------------------------------
        */

        $totalPengguna = Pengguna::count();

        $penggunaAktif = Pengguna::where('is_active', 1)->count();

        $penggunaNonAktif = $totalPengguna - $penggunaAktif;

        $pengguna = Pengguna::with('perusahaan')
            ->latest()
            ->limit(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA AKUN
        |--------------------------------------------------------------------------
        */

        $akunData = Akun::query()
            ->selectRaw('tipe_akun, COUNT(*) as total')
            ->where('is_active', 1)
            ->groupBy('tipe_akun')
            ->pluck('total', 'tipe_akun');

        $akunChart = [
            'Aset'       => $akunData['Aset'] ?? 0,
            'Liabilitas' => $akunData['Liabilitas'] ?? 0,
            'Ekuitas'    => $akunData['Ekuitas'] ?? 0,
            'Pendapatan' => $akunData['Pendapatan'] ?? 0,
            'Beban'      => $akunData['Beban'] ?? 0,
        ];

        $totalAkun = Akun::where('is_active', 1)->count();

        /*
        |--------------------------------------------------------------------------
        | DATA SUPPLIER
        |--------------------------------------------------------------------------
        */

        $totalSupplier = Supplier::count();

        $supplierTerbaru = Supplier::with('perusahaan')
            ->latest('id_supplier')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DEFAULT VALUE
        |--------------------------------------------------------------------------
        */

        $totalEarnings = 0;
        $earningsBulanIni = 0;
        $growthEarnings = 0;

        $totalTransaksi = 0;
        $growthTransaksi = 0;
        $transaksiPending = 0;

        $totalFakturPembelian = 0;
        $totalNominalPembelian = 0;

        $fakturLunas = 0;
        $fakturBelumLunas = 0;
        $fakturDibatalkan = 0;

        $totalPenerimaan = 0;

        $penerimaanHariIni = 0;
        $penerimaanBulanIni = 0;

        $growthHariIni = 0;
        $growthBulanIni = 0;

        $totalTransaksiPenerimaan = 0;

        /*
        |--------------------------------------------------------------------------
        | DATA BERDASARKAN PERUSAHAAN
        |--------------------------------------------------------------------------
        */

        if ($idPerusahaan) {

            /*
            |--------------------------------------------------------------------------
            | FAKTUR PENJUALAN
            |--------------------------------------------------------------------------
            */

            $fakturPenjualan = FakturPenjualan::query()
                ->where('id_perusahaan', $idPerusahaan);

            $totalEarnings = (clone $fakturPenjualan)
                ->where('status', 'Lunas')
                ->sum('total');

            $earningsBulanIni = (clone $fakturPenjualan)
                ->where('status', 'Lunas')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('total');

            $bulanLalu = (clone $fakturPenjualan)
                ->where('status', 'Lunas')
                ->whereMonth('tanggal', now()->subMonth()->month)
                ->whereYear('tanggal', now()->subMonth()->year)
                ->sum('total');

            if ($bulanLalu > 0) {
                $growthEarnings =
                    (($earningsBulanIni - $bulanLalu) / $bulanLalu) * 100;
            }

            $totalTransaksi = (clone $fakturPenjualan)->count();

            $mingguIni = (clone $fakturPenjualan)
                ->whereBetween('tanggal', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])
                ->count();

            $mingguLalu = (clone $fakturPenjualan)
                ->whereBetween('tanggal', [
                    now()->subWeek()->startOfWeek(),
                    now()->subWeek()->endOfWeek()
                ])
                ->count();

            if ($mingguLalu > 0) {
                $growthTransaksi =
                    (($mingguIni - $mingguLalu) / $mingguLalu) * 100;
            }

            $transaksiPending = (clone $fakturPenjualan)
                ->where('status', 'Belum Lunas')
                ->count();

            /*
            |--------------------------------------------------------------------------
            | FAKTUR PEMBELIAN
            |--------------------------------------------------------------------------
            */

            $fakturPembelian = FakturPembelian::query()
                ->where('id_perusahaan', $idPerusahaan);

            $totalFakturPembelian = (clone $fakturPembelian)->count();

            $totalNominalPembelian = (clone $fakturPembelian)
                ->sum('total');

            $fakturLunas = (clone $fakturPembelian)
                ->where('status', 'Lunas')
                ->count();

            $fakturBelumLunas = (clone $fakturPembelian)
                ->where('status', 'Belum Lunas')
                ->count();

            $fakturDibatalkan = (clone $fakturPembelian)
                ->where('status', 'Dibatalkan')
                ->count();

            /*
            |--------------------------------------------------------------------------
            | CHART PEMBELIAN
            |--------------------------------------------------------------------------
            */

            $chartData = (clone $fakturPembelian)
                ->selectRaw('MONTH(tanggal) as bulan, SUM(total) as total')
                ->whereYear('tanggal', now()->year)
                ->groupBy(DB::raw('MONTH(tanggal)'))
                ->orderBy(DB::raw('MONTH(tanggal)'))
                ->get();

            foreach ($chartData as $item) {

                $index = (int) $item->bulan - 1;

                if ($index >= 0 && $index < 12) {
                    $chartTotal[$index] = (float) $item->total;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | PENERIMAAN PIUTANG
            |--------------------------------------------------------------------------
            */

            $penerimaan = PenerimaanPiutang::query()
                ->where('id_perusahaan', $idPerusahaan);

            $totalPenerimaan = (clone $penerimaan)
                ->sum('jumlah');

            $totalTransaksiPenerimaan = (clone $penerimaan)
                ->count();

            $penerimaanHariIni = (clone $penerimaan)
                ->whereDate('tanggal', today())
                ->sum('jumlah');

            $kemarin = (clone $penerimaan)
                ->whereDate('tanggal', today()->subDay())
                ->sum('jumlah');

            if ($kemarin > 0) {
                $growthHariIni =
                    (($penerimaanHariIni - $kemarin) / $kemarin) * 100;
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
                $growthBulanIni =
                    (($penerimaanBulanIni - $bulanLaluPenerimaan)
                    / $bulanLaluPenerimaan) * 100;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DATA VIEW
        |--------------------------------------------------------------------------
        */

        $data = [

            'user' => $user,
            'title' => 'Dashboard',

            // perusahaan
            'total_perusahaan' => $totalPerusahaan,
            'kota_labels' => $kotaData->pluck('kota')->values(),
            'kota_data' => $kotaData->pluck('total')->values(),

            // pengguna
            'pengguna' => $pengguna,
            'total_pengguna' => $totalPengguna,
            'pengguna_aktif' => $penggunaAktif,
            'pengguna_nonaktif' => $penggunaNonAktif,

            // akun
            'akun_chart' => $akunChart,
            'total_akun' => $totalAkun,

            // supplier
            'total_supplier' => $totalSupplier,
            'supplier_terbaru' => $supplierTerbaru,

            // penjualan
            'total_earnings' => $totalEarnings,
            'earnings_bulan_ini' => $earningsBulanIni,
            'growth_earnings' => round($growthEarnings, 2),

            'total_transaksi' => $totalTransaksi,
            'growth_transaksi' => round($growthTransaksi, 2),
            'transaksi_pending' => $transaksiPending,

            // pembelian
            'total_faktur_pembelian' => $totalFakturPembelian,
            'total_nominal_pembelian' => $totalNominalPembelian,

            'faktur_lunas' => $fakturLunas,
            'faktur_belum_lunas' => $fakturBelumLunas,
            'faktur_dibatalkan' => $fakturDibatalkan,

            // chart
            'chart_bulan' => $chartBulan,
            'chart_total' => $chartTotal,

            // penerimaan
            'total_penerimaan' => $totalPenerimaan,
            'total_transaksi_penerimaan' => $totalTransaksiPenerimaan,

            'penerimaan_hari_ini' => $penerimaanHariIni,
            'penerimaan_bulan_ini' => $penerimaanBulanIni,

            'growth_hari_ini' => round($growthHariIni, 2),
            'growth_bulan_ini' => round($growthBulanIni, 2),
        ];

        /*
        |--------------------------------------------------------------------------
        | ROLE VIEW
        |--------------------------------------------------------------------------
        */

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
