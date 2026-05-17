<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AsetTetap;
use App\Models\Depresiasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepresiasiApiController extends Controller
{
    /**
     * GET ALL
     */
    public function index()
    {
        $data = Depresiasi::with('aset')
            ->latest('periode_depresiasi')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'List data depresiasi',
            'data' => $data
        ]);
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_aset' => 'required|exists:aset_tetap,id_aset',
            'periode_depresiasi' => 'required|date',
        ]);

        $aset = AsetTetap::findOrFail($request->id_aset);

        $harga  = (float) $aset->nilai_perolehan;
        $residu = (float) $aset->nilai_sisa;
        $umur   = (int) $aset->masa_manfaat;

        if ($umur <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Masa manfaat tidak valid'
            ], 422);
        }

        $nilaiDepresiasi =
            ($harga - $residu) / ($umur * 12);

        $depresiasi = Depresiasi::create([
            'id_aset' => $request->id_aset,
            'id_jurnal' => null,
            'periode_depresiasi' => $request->periode_depresiasi,
            'nilai_depresiasi' => $nilaiDepresiasi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $depresiasi
        ], 201);
    }

    /**
     * SHOW
     */
    public function show($id)
    {
        $data = Depresiasi::with('aset')
            ->find($id);

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
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $data = Depresiasi::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'periode_depresiasi' => 'required|date',
            'nilai_depresiasi' => 'required|numeric',
        ]);

        $data->update([
            'periode_depresiasi' =>
                $request->periode_depresiasi,

            'nilai_depresiasi' =>
                $request->nilai_depresiasi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $data
        ]);
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        $data = Depresiasi::find($id);

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

    /**
     * GENERATE BULANAN
     */
    public function generate(Request $request)
    {
        $periode = $request->filled('periode')
            ? Carbon::parse($request->periode)->startOfMonth()
            : now()->startOfMonth();

        DB::beginTransaction();

        try {

            $asetList = AsetTetap::all();

            foreach ($asetList as $aset) {

                $exists = Depresiasi::where(
                        'id_aset',
                        $aset->id_aset
                    )
                    ->whereYear(
                        'periode_depresiasi',
                        $periode->year
                    )
                    ->whereMonth(
                        'periode_depresiasi',
                        $periode->month
                    )
                    ->exists();

                if ($exists) {
                    continue;
                }

                $harga  = (float) $aset->nilai_perolehan;
                $residu = (float) $aset->nilai_sisa;
                $umur   = (int) $aset->masa_manfaat;

                if ($umur <= 0) {
                    continue;
                }

                $nilaiDepresiasi =
                    ($harga - $residu) / ($umur * 12);

                Depresiasi::create([
                    'id_aset' => $aset->id_aset,
                    'id_jurnal' => null,
                    'periode_depresiasi' =>
                        $periode->format('Y-m-d'),
                    'nilai_depresiasi' =>
                        $nilaiDepresiasi,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' =>
                    'Generate depresiasi berhasil'
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
