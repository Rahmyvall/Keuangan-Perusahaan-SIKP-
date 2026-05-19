<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MutasiRekeningBank;
use App\Models\RekeningBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MutasiRekeningBankController extends Controller
{
    // LIST MUTASI
    public function index()
    {
        return response()->json(
            MutasiRekeningBank::with('rekening')->latest()->get()
        );
    }

    // STORE MUTASI (INTI SISTEM)
    public function store(Request $request)
    {
        $request->validate([
            'id_rekening' => 'required|exists:rekening_bank,id_rekening',
            'tipe' => 'required|in:DEBIT,KREDIT',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {

            $rekening = RekeningBank::lockForUpdate()
                ->findOrFail($request->id_rekening);

            // hitung saldo awal
            $saldoSebelum = $rekening->saldo_awal;

            // kalau ada mutasi sebelumnya, ambil saldo terakhir
            $last = MutasiRekeningBank::where('id_rekening', $rekening->id_rekening)
                ->latest('id_mutasi')
                ->first();

            if ($last) {
                $saldoSebelum = $last->saldo_sesudah;
            }

            // hitung saldo baru
            $saldoSesudah = $request->tipe === 'KREDIT'
                ? $saldoSebelum + $request->jumlah
                : $saldoSebelum - $request->jumlah;

            if ($saldoSesudah < 0) {
                return response()->json([
                    'message' => 'Saldo tidak mencukupi'
                ], 422);
            }

            // simpan mutasi
            $mutasi = MutasiRekeningBank::create([
                'id_rekening' => $rekening->id_rekening,
                'tipe' => $request->tipe,
                'jumlah' => $request->jumlah,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSesudah,
                'keterangan' => $request->keterangan,
                'id_perusahaan' => $rekening->id_perusahaan,
            ]);

            return response()->json([
                'message' => 'Mutasi berhasil dibuat',
                'data' => $mutasi
            ]);
        });
    }

    // DETAIL
    public function show($id)
    {
        return MutasiRekeningBank::with('rekening')
            ->findOrFail($id);
    }

    // DELETE (opsional, biasanya dihindari di sistem akuntansi)
    public function destroy($id)
    {
        $data = MutasiRekeningBank::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Mutasi dihapus'
        ]);
    }
}
