<?php

namespace App\Http\Controllers;

use App\Models\AsetTetap;
use App\Models\Depresiasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepresiasiController extends Controller
{
    /**
     * INDEX
     */
    public function index(Request $request)
    {
        $query = Depresiasi::with('aset');

        if ($request->filled('id_aset')) {
            $query->where('id_aset', $request->id_aset);
        }

        if ($request->filled('periode')) {

            $periode = Carbon::parse($request->periode);

            $query->whereYear('periode_depresiasi', $periode->year)
                  ->whereMonth('periode_depresiasi', $periode->month);
        }

        $data = $query->latest('periode_depresiasi')
            ->paginate(15)
            ->withQueryString();

        $asetList = AsetTetap::select(
                'id_aset',
                'kode_aset',
                'nama_aset'
            )
            ->orderBy('kode_aset')
            ->get();

        return view('depresiasi.index', compact(
            'data',
            'asetList'
        ));
    }

    /**
     * GENERATE DEPRESIASI
     */
    public function generate(Request $request)
    {
        $periode = $request->filled('periode_depresiasi')
            ? Carbon::parse($request->periode_depresiasi)->startOfMonth()
            : now()->startOfMonth();

        DB::beginTransaction();

        try {

            $asetList = AsetTetap::all();

            foreach ($asetList as $aset) {

                $harga  = (float) $aset->nilai_perolehan;
                $residu = (float) $aset->nilai_sisa;
                $umur   = (int) $aset->masa_manfaat;

                if ($umur <= 0) {
                    continue;
                }

                /**
                 * CEK DUPLIKASI
                 */
                $exists = Depresiasi::where('id_aset', $aset->id_aset)
                    ->whereYear('periode_depresiasi', $periode->year)
                    ->whereMonth('periode_depresiasi', $periode->month)
                    ->exists();

                if ($exists) {
                    continue;
                }

                /**
                 * HITUNG DEPRESIASI BULANAN
                 */
                $nilaiDepresiasi = ($harga - $residu) / ($umur * 12);

                /**
                 * SIMPAN
                 */
                Depresiasi::create([
                    'id_aset'             => $aset->id_aset,
                    'id_jurnal'           => null,
                    'periode_depresiasi'  => $periode->format('Y-m-d'),
                    'nilai_depresiasi'    => $nilaiDepresiasi,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('depresiasi.index')
                ->with('success', 'Depresiasi berhasil digenerate');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    /**
     * SHOW DETAIL
     */
    public function show($id_aset)
    {
        $aset = AsetTetap::findOrFail($id_aset);

        $data = Depresiasi::where('id_aset', $id_aset)
            ->orderBy('periode_depresiasi', 'asc')
            ->get();

        $totalDepresiasi = $data->sum('nilai_depresiasi');

        $nilaiAkhir = max(
            $aset->nilai_perolehan - $totalDepresiasi,
            0
        );

        return view('depresiasi.show', compact(
            'aset',
            'data',
            'totalDepresiasi',
            'nilaiAkhir'
        ));
    }

    /**
     * PRINT PDF
     */
    public function print($id_aset)
    {
        $aset = AsetTetap::findOrFail($id_aset);

        $data = Depresiasi::where('id_aset', $id_aset)
            ->orderBy('periode_depresiasi', 'asc')
            ->get();

        $totalDepresiasi = $data->sum('nilai_depresiasi');

        $nilaiAkhir = max(
            $aset->nilai_perolehan - $totalDepresiasi,
            0
        );

        $pdf = Pdf::loadView('depresiasi.print', compact(
            'aset',
            'data',
            'totalDepresiasi',
            'nilaiAkhir'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream(
            'depresiasi-' . $aset->kode_aset . '.pdf'
        );
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        try {

            Depresiasi::findOrFail($id)->delete();

            return back()->with(
                'success',
                'Data berhasil dihapus'
            );

        } catch (\Throwable $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}
