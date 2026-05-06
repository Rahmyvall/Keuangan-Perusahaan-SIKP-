<?php

namespace App\Http\Controllers;

use App\Models\MataUang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataUangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = MataUang::query()
            ->search($request->search)        // pakai scopeSearch dari model
            ->orderBy('kode')
            ->paginate(9)
            ->withQueryString();

        return view('mata_uang.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mata_uang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        MataUang::create($validated);

        return redirect()
            ->route('mata-uang.index')
            ->with('success', 'Data mata uang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MataUang $mataUang)
    {
        return view('mata_uang.show', compact('mataUang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataUang $mataUang)
    {
        return view('mata_uang.edit', compact('mataUang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataUang $mataUang)
    {
        $validated = $this->validateData($request, $mataUang->id_mata_uang);

        $mataUang->update($validated);

        return redirect()
            ->route('mata-uang.index')
            ->with('success', 'Data mata uang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataUang $mataUang)
    {
        try {
            $mataUang->delete();

            return redirect()
                ->route('mata-uang.index')
                ->with('success', 'Data mata uang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data. Data sedang digunakan.');
        }
    }

    /**
     * Reusable validation rules
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
            'nama'   => 'required|string|max:50',
            'simbol' => 'nullable|string|max:10',
        ]);
    }
}
