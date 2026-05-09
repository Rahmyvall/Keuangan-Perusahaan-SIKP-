<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $data = Supplier::with('perusahaan')
        ->latest('id_supplier')
        ->paginate(10);

    return view('supplier.index', compact('data'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $perusahaan = Perusahaan::all();

    $lastSupplier = Supplier::latest('id_supplier')->first();

    if ($lastSupplier) {

        $lastNumber = (int) substr($lastSupplier->kode_supplier, 4);

        $newNumber = $lastNumber + 1;

    } else {

        $newNumber = 1;
    }

    $kodeSupplier = 'SUP-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    return view('supplier.create', compact(
        'perusahaan',
        'kodeSupplier'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama_supplier' => 'required|max:150',
        'telepon'       => 'nullable|max:30',
        'alamat'        => 'nullable',
        'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
    ]);

    // Generate kode otomatis
    $lastSupplier = Supplier::latest('id_supplier')->first();

    if ($lastSupplier && $lastSupplier->kode_supplier) {

        $lastNumber = (int) str_replace('SUP-', '', $lastSupplier->kode_supplier);

        $newNumber = $lastNumber + 1;

    } else {

        $newNumber = 1;
    }

    $kodeSupplier = 'SUP-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    Supplier::create([
        'kode_supplier' => $kodeSupplier,
        'nama_supplier' => $request->nama_supplier,
        'telepon'       => $request->telepon,
        'alamat'        => $request->alamat,
        'id_perusahaan' => $request->id_perusahaan,
    ]);

    return redirect()
        ->route('supplier.index')
        ->with('success', 'Data supplier berhasil ditambahkan');
}
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Supplier::with('perusahaan')
            ->findOrFail($id);

        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        $perusahaan = Perusahaan::orderBy('nama_perusahaan')->get();

        return view('supplier.edit', compact('supplier', 'perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'kode_supplier' => 'nullable|string|max:20|unique:supplier,kode_supplier,' . $supplier->id_supplier . ',id_supplier',
            'nama_supplier' => 'required|string|max:150',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string|max:30',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Data supplier berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Data supplier berhasil dihapus');
    }
}