<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PembayaranHutang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PembayaranHutangController extends Controller
{
    /**
     * GET /api/pembayaran-hutang
     */
    public function index()
    {
        $data = PembayaranHutang::with([
            'fakturPembelian',
            'jurnal',
            'perusahaan'
        ])->get();

        return response()->json([
            'success' => true,
            'message' => 'Data pembayaran hutang berhasil diambil',
            'data' => $data
        ]);
    }

    /**
     * POST /api/pembayaran-hutang
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_pembayaran' => 'required|string|max:50|unique:pembayaran_hutang,nomor_pembayaran',
            'tanggal' => 'required|date',
            'id_faktur_pembelian' => 'required|exists:faktur_pembelian,id_faktur_pembelian',
            'id_jurnal' => 'nullable|exists:jurnal,id_jurnal',
            'jumlah' => 'required|numeric|min:0',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $data = PembayaranHutang::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran hutang berhasil ditambahkan',
            'data' => $data
        ], 201);
    }

    /**
     * GET /api/pembayaran-hutang/{id}
     */
    public function show($id)
    {
        $data = PembayaranHutang::with([
            'fakturPembelian',
            'jurnal',
            'perusahaan'
        ])->find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * PUT /api/pembayaran-hutang/{id}
     */
    public function update(Request $request, $id)
    {
        $data = PembayaranHutang::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nomor_pembayaran' => [
                'required',
                'string',
                'max:50',
                Rule::unique('pembayaran_hutang', 'nomor_pembayaran')
                    ->ignore($id, 'id_pembayaran')
            ],
            'tanggal' => 'required|date',
            'id_faktur_pembelian' => 'required|exists:faktur_pembelian,id_faktur_pembelian',
            'id_jurnal' => 'nullable|exists:jurnal,id_jurnal',
            'jumlah' => 'required|numeric|min:0',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $data->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $data
        ]);
    }

    /**
     * DELETE /api/pembayaran-hutang/{id}
     */
    public function destroy($id)
    {
        $data = PembayaranHutang::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
