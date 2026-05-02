<?php

namespace App\Http\Controllers;

use App\Models\MataUang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataUangController extends Controller
{
    /**
     * List data + search + pagination
     */
    public function index(Request $request)
    {
        $query = MataUang::query();

        if ($request->search) {
            $query->where('kode', 'like', "%{$request->search}%")
                ->orWhere('nama', 'like', "%{$request->search}%");
        }

        $data = $query->orderBy('kode')->paginate(9)->withQueryString();

        return view('mata_uang.index', compact('data'));
    }
    /**
     * Form create
     */
    public function create()
    {
        return view('mata_uang.create');
    }

    /**
     * Simpan data
     */
    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        MataUang::create($validated);

        return redirect()
            ->route('mata-uang.index')
            ->with('success', 'Data mata uang berhasil ditambahkan');
    }

    /**
     * Detail
     */
    public function show(MataUang $mataUang)
    {
        return view('mata_uang.show', compact('mataUang'));
    }

    /**
     * Form edit
     */
    public function edit(MataUang $mataUang)
    {
        return view('mata_uang.edit', compact('mataUang'));
    }

    /**
     * Update data
     */
    public function update(Request $request, MataUang $mataUang)
    {
        $validated = $this->validateData($request, $mataUang->id_mata_uang);

        $mataUang->update($validated);

        return redirect()
            ->route('mata-uang.index')
            ->with('success', 'Data mata uang berhasil diperbarui');
    }

    /**
     * Hapus data
     */
    public function destroy(MataUang $mataUang)
    {
        try {
            $mataUang->delete();

            return redirect()->back()
                ->with('success', 'Data mata uang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data');
        }
    }

    /**
     * 🔥 Reusable validation
     */
    private function validateData(Request $request, $id = null)
    {
        return $request->validate([
            'kode' => [
                'required',
                'string',
                'max:3',
                Rule::unique('mata_uang', 'kode')->ignore($id, 'id_mata_uang'),
            ],
            'nama' => 'required|string|max:50',
            'simbol' => 'nullable|string|max:10',
        ]);
    }
}