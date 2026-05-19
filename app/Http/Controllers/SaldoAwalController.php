<?php

namespace App\Http\Controllers;

use App\Models\SaldoAwal;
use App\Models\Akun;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaldoAwalController extends Controller
{
    /**
     * INDEX
     */
    public function index(Request $request)
    {
        $query = SaldoAwal::with(['akun', 'periode']);

        // FILTER AKUN
        if ($request->filled('id_akun')) {
            $query->where('id_akun', $request->id_akun);
        }

        // FILTER PERIODE (FIX: tidak pakai tanggal_mulai lagi)
        if ($request->filled('id_periode')) {
            $query->where('id_periode', $request->id_periode);
        }

        $data = $query->latest('id_saldo')
            ->paginate(15)
            ->withQueryString();

        $akunList = Akun::orderBy('nama_akun')->get();

        // FIX: tidak pakai tanggal_mulai
        $periodeList = Periode::orderBy('id_periode', 'desc')->get();

        return view('saldo_awal.index', compact(
            'data',
            'akunList',
            'periodeList'
        ));
    }

    public function create()
{
    $akunList = \App\Models\Akun::orderBy('nama_akun')->get();
    $periodeList = \App\Models\Periode::orderBy('id_periode')->get();

    return view('saldo_awal.create', compact('akunList', 'periodeList'));
}

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_akun' => 'required|exists:akun,id_akun',
            'id_periode' => 'required|exists:periode,id_periode',
            'debit' => 'nullable|numeric|min:0',
            'kredit' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            // CEK DUPLIKASI
            $exists = SaldoAwal::where('id_akun', $request->id_akun)
                ->where('id_periode', $request->id_periode)
                ->exists();

            if ($exists) {
                return back()->with('error', 'Saldo awal sudah ada untuk akun & periode ini');
            }

            // SIMPAN
            SaldoAwal::create([
                'id_akun' => $request->id_akun,
                'id_periode' => $request->id_periode,
                'debit' => $request->debit ?? 0,
                'kredit' => $request->kredit ?? 0,
            ]);

            DB::commit();

            return redirect()
                ->route('saldo-awal.index')
                ->with('success', 'Saldo awal berhasil ditambahkan');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * SHOW
     */
    public function show($id_akun)
    {
        $akun = Akun::findOrFail($id_akun);

        $data = SaldoAwal::where('id_akun', $id_akun)
            ->with('periode')
            ->orderBy('id_periode', 'asc')
            ->get();

        $totalDebit = $data->sum('debit');
        $totalKredit = $data->sum('kredit');

        $saldoAkhir = $totalDebit - $totalKredit;

        return view('saldo_awal.show', compact(
            'akun',
            'data',
            'totalDebit',
            'totalKredit',
            'saldoAkhir'
        ));
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        try {

            SaldoAwal::findOrFail($id)->delete();

            return back()->with('success', 'Data berhasil dihapus');

        } catch (\Throwable $e) {

            return back()->with('error', $e->getMessage());
        }
    }
}