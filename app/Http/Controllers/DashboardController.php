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

        $idPerusahaan = $user->id_perusahaan
            ?? $user->perusahaan_id
            ?? $user->perusahaan?->id_perusahaan
            ?? null;

        /*
        |--------------------------------------------------------------------------
        | DATA DEFAULT
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

        $kotaData = Perusahaan::selectRaw('kota, COUNT(*) as total')
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

        $penggunaAktif = Pengguna::where('is_active', true)->count();

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

        $akunData = Akun::selectRaw('tipe_akun, COUNT(*) as total')
            ->where('is_active', true)
            ->groupBy('tipe_akun')
            ->pluck('total', 'tipe_akun');

        $akunChart = [
            'Aset'       => $akunData['Aset'] ?? 0,
            'Liabilitas' => $akunData['Liabilitas'] ?? 0,
            'Ekuitas'    => $akunData['Ekuitas'] ?? 0,
            'Pendapatan' => $akunData['Pendapatan'] ?? 0,
            'Beban'      => $akunData['Beban'] ?? 0,
        ];

        $totalAkun = Akun::where('is_active', true)->count();

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
        | FAKTUR PENJUALAN
        |--------------------------------------------------------------------------
        */

        $totalEarnings = 0;
        $earningsBulanIni = 0;
        $growthEarnings = 0;
        $totalTransaksi = 0;
        $growthTransaksi = 0;
        $transaksiPending = 0;

        if ($idPerusahaan) {

            $fakturPenjualan = FakturPenjualan::where(
                'id_perusahaan',
                $idPerusahaan
            );

            $totalEarnings = (clone $fakturPenjualan)
                ->where('status', 'Lunas')
                ->sum('total');

            $earningsBulanIni = (clone $fakturPenjualan)
                ->where('status', 'Lunas')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('total');

            $totalTransaksi = (clone $fakturPenjualan)->count();

            $transaksiPending = (clone $fakturPenjualan)
                ->where('status', 'Belum Lunas')
                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | FAKTUR PEMBELIAN
        |--------------------------------------------------------------------------
        */

        $totalFakturPembelian = 0;
        $totalNominalPembelian = 0;
        $fakturLunas = 0;
        $fakturBelumLunas = 0;
        $fakturDibatalkan = 0;

        if ($idPerusahaan) {

            $fakturPembelian = FakturPembelian::where(
                'id_perusahaan',
                $idPerusahaan
            );

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
            | GRAFIK LINE PEMBELIAN
            |--------------------------------------------------------------------------
            */

            $chartData = (clone $fakturPembelian)
                ->select(
                    DB::raw('MONTH(tanggal) as bulan'),
                    DB::raw('SUM(total) as total')
                )
                ->whereYear('tanggal', now()->year)
                ->groupBy(DB::raw('MONTH(tanggal)'))
                ->orderBy(DB::raw('MONTH(tanggal)'))
                ->get();

            foreach ($chartData as $item) {

                $index = $item->bulan - 1;

                $chartTotal[$index] = (float) $item->total;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PENERIMAAN PIUTANG
        |--------------------------------------------------------------------------
        */

        $totalPenerimaan = 0;

        if ($idPerusahaan) {

            $totalPenerimaan = PenerimaanPiutang::where(
                'id_perusahaan',
                $idPerusahaan
            )->sum('jumlah');
        }

        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA
        |--------------------------------------------------------------------------
        */

        $data = [

            'user' => $user,
            'title' => 'Dashboard',

            // perusahaan
            'total_perusahaan' => $totalPerusahaan,
            'kota_labels' => $kotaData->pluck('kota'),
            'kota_data' => $kotaData->pluck('total'),

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

            // faktur penjualan
            'total_earnings' => $totalEarnings,
            'earnings_bulan_ini' => $earningsBulanIni,
            'total_transaksi' => $totalTransaksi,
            'transaksi_pending' => $transaksiPending,

            // faktur pembelian
            'total_faktur_pembelian' => $totalFakturPembelian,
            'total_nominal_pembelian' => $totalNominalPembelian,
            'faktur_lunas' => $fakturLunas,
            'faktur_belum_lunas' => $fakturBelumLunas,
            'faktur_dibatalkan' => $fakturDibatalkan,

            // chart
            'chart_bulan' => $chartBulan,
            'chart_total' => $chartTotal,

            // piutang
            'total_penerimaan' => $totalPenerimaan,
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