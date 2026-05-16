<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\AsetTetap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AsetTetapController extends Controller
{
    // GET ALL
    public function index()
    {
        $aset = AsetTetap::with([
            'akunAset',
            'perusahaan'
        ])->latest('id_aset')->get();

        return response()->json([
            'success' => true,
            'data' => $aset
        ]);
    }

    // STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_aset'         => 'required|max:150',
            'id_akun_aset'      => 'required|exists:akun,id_akun',
            'tanggal_pengadaan' => 'required|date',
            'nilai_perolehan'   => 'required|numeric',
            'masa_manfaat'      => 'required|integer',
            'nilai_sisa'        => 'nullable|numeric',
            'id_perusahaan'     => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $validated['nilai_sisa'] =
            $validated['nilai_sisa'] ?? 0;

        // Generate kode aset
        $tanggal = Carbon::parse(
            $validated['tanggal_pengadaan']
        );

        $prefix = 'AST-' . $tanggal->format('Ymd');

        $last = AsetTetap::where(
            'kode_aset',
            'like',
            "{$prefix}-%"
        )->latest('id_aset')->first();

        $nomor = $last
            ? (int) substr($last->kode_aset, -4) + 1
            : 1;

        $validated['kode_aset'] =
            $prefix . '-' .
            str_pad($nomor, 4, '0', STR_PAD_LEFT);

        $aset = AsetTetap::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $aset
        ], 201);
    }

    // SHOW
    public function show(AsetTetap $asetTetap)
    {
        $asetTetap->load([
            'akunAset',
            'perusahaan'
        ]);

        return response()->json([
            'success' => true,
            'data' => $asetTetap
        ]);
    }

    // UPDATE
    public function update(
        Request $request,
        AsetTetap $asetTetap
    ) {
        $validated = $request->validate([
            'nama_aset'         => 'required|max:150',
            'id_akun_aset'      => 'required|exists:akun,id_akun',
            'tanggal_pengadaan' => 'required|date',
            'nilai_perolehan'   => 'required|numeric',
            'masa_manfaat'      => 'required|integer',
            'nilai_sisa'        => 'nullable|numeric',
            'id_perusahaan'     => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $asetTetap->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $asetTetap
        ]);
    }

    // DELETE
    public function destroy(AsetTetap $asetTetap)
    {
        $asetTetap->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
