<?php

namespace App\Http\Controllers;

use App\Models\JurnalDetail;
use App\Models\Jurnal;
use App\Models\Akun;
use App\Models\MataUang;
use Illuminate\Http\Request;

class JurnalDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JurnalDetail::with(['jurnal', 'akun', 'mataUang']);

        $jurnal = null;

        // Filter berdasarkan id_jurnal (paling sering digunakan)
        if ($request->filled('id_jurnal')) {
            $jurnal = Jurnal::findOrFail($request->id_jurnal);
            $query->where('id_jurnal', $request->id_jurnal);
        }

        $details = $query->latest('id_detail')->paginate(50);

        return view('jurnal_details.index', compact('details', 'jurnal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $id_jurnal = $request->id_jurnal;

        $jurnal = Jurnal::findOrFail($id_jurnal);
        $akuns = Akun::orderBy('kode_akun')->get();
        $mataUangs = MataUang::all();

        return view('jurnal_details.create', compact('jurnal', 'akuns', 'mataUangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jurnal'     => 'required|exists:jurnal,id_jurnal',
            'id_akun'       => 'required|exists:akun,id_akun',
            'debit'         => 'required|numeric|min:0',
            'kredit'        => 'required|numeric|min:0',
            'keterangan'    => 'nullable|string|max:500',
            'id_mata_uang'  => 'required|exists:mata_uang,id_mata_uang',
            'kurs'          => 'required|numeric|min:0',
        ]);

        // Validasi bisnis: tidak boleh keduanya bernilai > 0
        if ($validated['debit'] > 0 && $validated['kredit'] > 0) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'Hanya boleh mengisi salah satu antara Debit atau Kredit.']);
        }

        // Validasi bisnis: tidak boleh keduanya 0
        if ($validated['debit'] == 0 && $validated['kredit'] == 0) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'Debit atau Kredit harus diisi minimal salah satu.']);
        }

        JurnalDetail::create($validated);

        return redirect()
            ->route('jurnal.show', $validated['id_jurnal'])
            ->with('success', 'Detail jurnal berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JurnalDetail $jurnalDetail)
    {
        $jurnalDetail->load(['jurnal', 'akun', 'mataUang']);

        $akuns = Akun::orderBy('kode_akun')->get();
        $mataUangs = MataUang::all();

        return view('jurnal_details.edit', compact('jurnalDetail', 'akuns', 'mataUangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JurnalDetail $jurnalDetail)
    {
        $validated = $request->validate([
            'id_akun'       => 'required|exists:akun,id_akun',
            'debit'         => 'required|numeric|min:0',
            'kredit'        => 'required|numeric|min:0',
            'keterangan'    => 'nullable|string|max:500',
            'id_mata_uang'  => 'required|exists:mata_uang,id_mata_uang',
            'kurs'          => 'required|numeric|min:0',
        ]);

        if ($validated['debit'] > 0 && $validated['kredit'] > 0) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'Hanya boleh mengisi salah satu antara Debit atau Kredit.']);
        }

        if ($validated['debit'] == 0 && $validated['kredit'] == 0) {
            return back()
                ->withInput()
                ->withErrors(['message' => 'Debit atau Kredit harus diisi minimal salah satu.']);
        }

        $jurnalDetail->update($validated);

        return redirect()
            ->route('jurnal.show', $jurnalDetail->id_jurnal)
            ->with('success', 'Detail jurnal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JurnalDetail $jurnalDetail)
    {
        $id_jurnal = $jurnalDetail->id_jurnal;
        $jurnalDetail->delete();

        return redirect()
            ->route('jurnal.show', $id_jurnal)
            ->with('success', 'Detail jurnal berhasil dihapus.');
    }

    /**
     * Bulk delete (opsional - bisa dipakai via AJAX)
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:jurnal_detail,id_detail'
        ]);

        JurnalDetail::whereIn('id_detail', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
