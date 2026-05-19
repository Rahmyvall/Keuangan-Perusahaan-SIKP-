<?php

namespace App\Http\Controllers;

use App\Models\RekeningBank;
use App\Models\Akun;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RekeningBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekeningBank = RekeningBank::with([
            'akunKas',
            'perusahaan'
        ])->latest('id_rekening')->paginate(10);

        return view('rekening_bank.index', compact('rekeningBank'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $akun = Akun::all();
    $perusahaan = Perusahaan::all();

    do {

        // Generate 12 digit angka
        $nomorRekening = str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT);

    } while (
        RekeningBank::where('nomor_rekening', $nomorRekening)->exists()
    );

    return view('rekening_bank.create', compact(
        'akun',
        'perusahaan',
        'nomorRekening'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50|unique:rekening_bank,nomor_rekening',
            'nama_rekening' => 'required|string|max:100',
            'id_akun_kas' => 'required|exists:akun,id_akun',
            'saldo_awal' => 'nullable|numeric|min:0',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        RekeningBank::create($validated);

        return redirect()
            ->route('rekening-bank.index')
            ->with('success', 'Data rekening bank berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rekeningBank = RekeningBank::with([
            'akunKas',
            'perusahaan'
        ])->findOrFail($id);

        return view('rekening_bank.show', compact('rekeningBank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rekeningBank = RekeningBank::findOrFail($id);

        $akun = Akun::orderBy('nama_akun')->get();
        $perusahaan = Perusahaan::orderBy('nama_perusahaan')->get();

        return view('rekening_bank.edit', compact(
            'rekeningBank',
            'akun',
            'perusahaan'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rekeningBank = RekeningBank::findOrFail($id);

        $validated = $request->validate([
            'nama_bank' => 'required|string|max:100',
            'nomor_rekening' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rekening_bank', 'nomor_rekening')
                    ->ignore($rekeningBank->id_rekening, 'id_rekening')
            ],
            'nama_rekening' => 'required|string|max:100',
            'id_akun_kas' => 'required|exists:akun,id_akun',
            'saldo_awal' => 'nullable|numeric|min:0',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $rekeningBank->update($validated);

        return redirect()
            ->route('rekening-bank.index')
            ->with('success', 'Data rekening bank berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rekeningBank = RekeningBank::findOrFail($id);

        $rekeningBank->delete();

        return redirect()
            ->route('rekening-bank.index')
            ->with('success', 'Data rekening bank berhasil dihapus.');
    }
}
