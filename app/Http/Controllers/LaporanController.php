<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | NERACA (BALANCE SHEET)
    |--------------------------------------------------------------------------
    */
    public function neraca(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->format('Y-m-d');

        $akun = Akun::where('is_active', true)
            ->orderBy('kode_akun')
            ->get()
            ->groupBy('tipe_akun');

        $data = [
            'Aset' => $this->hitungSaldo($akun['Aset'] ?? [], null, $tanggal),
            'Liabilitas' => $this->hitungSaldo($akun['Liabilitas'] ?? [], null, $tanggal),
            'Ekuitas' => $this->hitungSaldo($akun['Ekuitas'] ?? [], null, $tanggal),
        ];

        $totalAset = collect($data['Aset'])->sum('saldo');
        $totalLiabilitas = collect($data['Liabilitas'])->sum('saldo');
        $totalEkuitas = collect($data['Ekuitas'])->sum('saldo');

        return response()->json([
            'success' => true,
            'tanggal' => $tanggal,
            'data' => $data,
            'total' => [
                'aset' => $totalAset,
                'liabilitas' => $totalLiabilitas,
                'ekuitas' => $totalEkuitas,
            ],
            'balance_check' => ($totalAset == ($totalLiabilitas + $totalEkuitas))
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LABA RUGI (INCOME STATEMENT)
    |--------------------------------------------------------------------------
    */
    public function labaRugi(Request $request)
    {
        $start = $request->start ?? now()->startOfMonth()->format('Y-m-d');
        $end = $request->end ?? now()->endOfMonth()->format('Y-m-d');

        $akunPendapatan = Akun::where('tipe_akun', 'Pendapatan')
            ->where('is_active', true)
            ->get();

        $akunBeban = Akun::where('tipe_akun', 'Beban')
            ->where('is_active', true)
            ->get();

        $pendapatan = $this->hitungSaldo($akunPendapatan, $start, $end);
        $beban = $this->hitungSaldo($akunBeban, $start, $end);

        $totalIncome = collect($pendapatan)->sum('saldo');
        $totalExpense = collect($beban)->sum('saldo');

        return response()->json([
            'success' => true,
            'periode' => [
                'start' => $start,
                'end' => $end
            ],
            'pendapatan' => $pendapatan,
            'beban' => $beban,
            'total' => [
                'pendapatan' => $totalIncome,
                'beban' => $totalExpense,
                'laba_rugi' => $totalIncome - $totalExpense
            ]
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG SALDO AKUN (SUDAH FIX - BERBASIS JURNAL)
    |--------------------------------------------------------------------------
    */
    private function hitungSaldo($akunList, $start = null, $end = null)
    {
        return collect($akunList)->map(function ($akun) use ($start, $end) {

            $query = DB::table('jurnal_detail')
                ->join('jurnal', 'jurnal.id_jurnal', '=', 'jurnal_detail.id_jurnal')
                ->where('jurnal_detail.id_akun', $akun->id_akun);

            if ($start && $end) {
                $query->whereBetween('jurnal.tanggal', [$start, $end]);
            }

            $debit = (clone $query)->sum('jurnal_detail.debit');
            $kredit = (clone $query)->sum('jurnal_detail.kredit');

            // LOGIKA AKUNTANSI BENAR
            if ($akun->saldo_normal == 'Debit') {
                $saldo = $debit - $kredit;
            } else {
                $saldo = $kredit - $debit;
            }

            return [
                'kode_akun' => $akun->kode_akun,
                'nama_akun' => $akun->nama_akun,
                'saldo' => $saldo
            ];
        });
    }
}