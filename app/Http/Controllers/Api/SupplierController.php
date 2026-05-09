<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;

class SupplierController extends Controller
{
    public function index()
    {
        $data = Supplier::with('perusahaan')
            ->latest('id_supplier')
            ->paginate(10);

        return SupplierResource::collection($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_supplier' => 'nullable|string|max:20|unique:supplier,kode_supplier',
            'nama_supplier' => 'required|string|max:150',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string|max:30',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $supplier = Supplier::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil ditambahkan',
            'data'    => new SupplierResource($supplier->load('perusahaan'))
        ], 201);
    }

    public function show(Supplier $supplier)
    {
        $supplier->load('perusahaan');

        return response()->json([
            'success' => true,
            'message' => 'Detail supplier',
            'data'    => new SupplierResource($supplier)
        ]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'kode_supplier' => 'nullable|string|max:20|unique:supplier,kode_supplier,' . $supplier->id_supplier . ',id_supplier',
            'nama_supplier' => 'required|string|max:150',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string|max:30',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $supplier->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil diupdate',
            'data'    => new SupplierResource($supplier->load('perusahaan'))
        ]);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil dihapus'
        ]);
    }
}
