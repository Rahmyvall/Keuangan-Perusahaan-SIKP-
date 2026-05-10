<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FakturPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakturPembelianApiController extends Controller
{
    public function index()
    {
        $data = FakturPembelian::with([
            'supplier',
            'jurnal',
            'perusahaan'
        ])->latest('id_faktur_pembelian')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data faktur pembelian',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'id_jurnal' => 'nullable|exists:jurnal,id_jurnal',
            'subtotal' => 'required|numeric|min:0',
            'ppn' => 'nullable|numeric|min:0',
            'status' => 'required|in:Belum Lunas,Lunas,Dibatalkan',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        DB::beginTransaction();

        try {

            $last = FakturPembelian::latest(
                'id_faktur_pembelian'
            )->first();

            $number = $last
                ? ((int) substr($last->nomor_faktur, 3)) + 1
                : 1;

            $nomorFaktur = 'FB-' .
                str_pad($number, 5, '0', STR_PAD_LEFT);

            $subtotal = $validated['subtotal'];
            $ppn = $validated['ppn'] ?? 0;
            $total = $subtotal + $ppn;

            $faktur = FakturPembelian::create([
                'nomor_faktur' => $nomorFaktur,
                'tanggal' => $validated['tanggal'],
                'id_supplier' => $validated['id_supplier'],
                'id_jurnal' => $validated['id_jurnal'] ?? null,
                'subtotal' => $subtotal,
                'ppn' => $ppn,
                'total' => $total,
                'status' => $validated['status'],
                'id_perusahaan' => $validated['id_perusahaan'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Faktur berhasil dibuat',
                'data' => $faktur
            ], 201);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $faktur = FakturPembelian::with([
            'supplier',
            'jurnal',
            'perusahaan'
        ])->find($id);

        if (!$faktur) {

            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $faktur
        ]);
    }

    public function update(Request $request, $id)
    {
        $faktur = FakturPembelian::find($id);

        if (!$faktur) {

            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'id_jurnal' => 'nullable|exists:jurnal,id_jurnal',
            'subtotal' => 'required|numeric|min:0',
            'ppn' => 'nullable|numeric|min:0',
            'status' => 'required|in:Belum Lunas,Lunas,Dibatalkan',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        DB::beginTransaction();

        try {

            $subtotal = $validated['subtotal'];
            $ppn = $validated['ppn'] ?? 0;

            $faktur->update([
                'tanggal' => $validated['tanggal'],
                'id_supplier' => $validated['id_supplier'],
                'id_jurnal' => $validated['id_jurnal'] ?? null,
                'subtotal' => $subtotal,
                'ppn' => $ppn,
                'total' => $subtotal + $ppn,
                'status' => $validated['status'],
                'id_perusahaan' => $validated['id_perusahaan'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Faktur berhasil diupdate',
                'data' => $faktur
            ]);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $faktur = FakturPembelian::find($id);

        if (!$faktur) {

            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $faktur->delete();

        return response()->json([
            'success' => true,
            'message' => 'Faktur berhasil dihapus'
        ]);
    }
}
