<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\MataUang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    /**
     * =========================
     * INDEX (COA LIST + CHART)
     * =========================
     */
    public function index()
    {
        $data = Akun::with('parent')
            ->orderBy('kode_akun')
            ->get();

        return view('akun.index', compact('data'));
    }

    /**
     * =========================
     * CREATE FORM
     * =========================
     */
    public function create()
    {
        $akun = Akun::orderBy('kode_akun')->get();
        $mataUang = MataUang::all();

        return view('akun.create', compact('akun', 'mataUang'));
    }

    /**
     * =========================
     * STORE
     * =========================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_akun' => 'required|unique:akun,kode_akun|max:20',
            'nama_akun' => 'required|max:150',
            'tipe_akun' => ['required', Rule::in(['Aset','Liabilitas','Ekuitas','Pendapatan','Beban'])],
            'saldo_normal' => ['required', Rule::in(['Debit','Kredit'])],
            'level' => 'required|integer|min:1',
            'parent_id' => 'nullable|exists:akun,id_akun',
            'id_mata_uang' => 'nullable|exists:mata_uang,id_mata_uang',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? 1;

        Akun::create($validated);

        return redirect()->route('akun.index')
            ->with('success', 'Akun berhasil ditambahkan');
    }

    /**
     * =========================
     * SHOW
     * =========================
     */
    public function show($id)
    {
        $akun = Akun::with('parent')->findOrFail($id);

        return view('akun.show', compact('akun'));
    }

    /**
     * =========================
     * EDIT
     * =========================
     */
    public function edit($id)
    {
        $akun = Akun::findOrFail($id);

        // penting: hindari parent dirinya sendiri
        $allAkun = Akun::where('id_akun', '!=', $id)
            ->orderBy('kode_akun')
            ->get();

        return view('akun.edit', compact('akun', 'allAkun'));
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update(Request $request, $id)
    {
        $akun = Akun::findOrFail($id);

        $validated = $request->validate([
            'kode_akun' => [
                'required',
                'max:20',
                Rule::unique('akun', 'kode_akun')->ignore($akun->id_akun, 'id_akun')
            ],
            'nama_akun' => 'required|max:150',
            'tipe_akun' => ['required', Rule::in(['Aset','Liabilitas','Ekuitas','Pendapatan','Beban'])],
            'saldo_normal' => ['required', Rule::in(['Debit','Kredit'])],
            'level' => 'required|integer|min:1',
            'parent_id' => 'nullable|exists:akun,id_akun',
            'id_mata_uang' => 'nullable|exists:mata_uang,id_mata_uang',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? 1;

        $akun->update($validated);

        return redirect()->route('akun.index')
            ->with('success', 'Akun berhasil diupdate');
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function destroy($id)
    {
        $akun = Akun::findOrFail($id);

        // cek child
        if ($akun->children()->count() > 0) {
            return back()->with('error', 'Akun memiliki sub akun');
        }

        $akun->delete();

        return back()->with('success', 'Akun berhasil dihapus');
    }

    /**
     * =========================
     * AJAX BY TIPE
     * =========================
     */
    public function byTipe($tipe)
    {
        return Akun::where('tipe_akun', $tipe)
            ->orderBy('kode_akun')
            ->get();
    }
}