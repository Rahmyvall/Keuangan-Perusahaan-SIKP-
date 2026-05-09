<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenerimaanPiutang;
use App\Http\Requests\StorePenerimaanPiutangRequest;
use App\Http\Requests\UpdatePenerimaanPiutangRequest;
use Illuminate\Http\Request;

class PenerimaanPiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PenerimaanPiutang::with(['fakturPenjualan', 'jurnal', 'perusahaan']);

        if ($request->filled('tanggal')) {
            $query->tanggal($request->tanggal);
        }
        if ($request->filled('id_perusahaan')) {
            $query->perusahaan($request->id_perusahaan);
        }
        if ($request->filled('search')) {
            $query->where('nomor_penerimaan', 'like', '%' . $request->search . '%');
        }

        $data = $query->latest('tanggal')->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Data penerimaan piutang berhasil diambil',
            'data'    => $data,
            'meta'    => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenerimaanPiutangRequest $request)
    {
        $data = $request->validated();

        if (empty($data['nomor_penerimaan'])) {
            $data['nomor_penerimaan'] = $this->generateNomorPenerimaan();
        }

        $penerimaan = PenerimaanPiutang::create($data);

        $penerimaan->load(['fakturPenjualan', 'jurnal', 'perusahaan']);

        return response()->json([
            'success' => true,
            'message' => 'Penerimaan piutang berhasil dibuat',
            'data'    => $penerimaan
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penerimaan = PenerimaanPiutang::with(['fakturPenjualan', 'jurnal', 'perusahaan'])
                        ->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Data ditemukan',
            'data'    => $penerimaan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenerimaanPiutangRequest $request, $id)
    {
        $penerimaan = PenerimaanPiutang::findOrFail($id);
        $penerimaan->update($request->validated());

        $penerimaan->load(['fakturPenjualan', 'jurnal', 'perusahaan']);

        return response()->json([
            'success' => true,
            'message' => 'Penerimaan piutang berhasil diperbarui',
            'data'    => $penerimaan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penerimaan = PenerimaanPiutang::findOrFail($id);
        $penerimaan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Penerimaan piutang berhasil dihapus'
        ]);
    }

    /**
     * Generate Nomor Penerimaan Otomatis
     */
    private function generateNomorPenerimaan()
    {
        $prefix = 'RCV';
        $date = now()->format('Ymd');

        $lastRecord = PenerimaanPiutang::where('nomor_penerimaan', 'like', "{$prefix}-{$date}-%")
                        ->orderBy('nomor_penerimaan', 'desc')
                        ->first();

        $newNumber = $lastRecord
            ? str_pad((int) substr($lastRecord->nomor_penerimaan, -3) + 1, 3, '0', STR_PAD_LEFT)
            : '001';

        return "{$prefix}-{$date}-{$newNumber}";
    }
}
