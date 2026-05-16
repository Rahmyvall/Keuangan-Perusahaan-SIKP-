<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\AsetTetap;
use App\Models\Perusahaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AsetTetapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AsetTetap::with(['akunAset', 'perusahaan']);

        // Filter perusahaan
        if ($request->filled('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        // Filter tanggal pengadaan
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pengadaan', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('kode_aset', 'like', "%{$search}%")
                  ->orWhere('nama_aset', 'like', "%{$search}%");
            });
        }

        $asetTetap = $query
            ->latest('id_aset')
            ->paginate(15)
            ->withQueryString();

        $perusahaan = Perusahaan::select('id_perusahaan', 'nama_perusahaan')
            ->orderBy('nama_perusahaan')
            ->get();

        return view('aset-tetap.index', compact(
            'asetTetap',
            'perusahaan'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akun = Akun::select('id_akun', 'kode_akun', 'nama_akun')
            ->orderBy('kode_akun')
            ->get();

        $perusahaan = Perusahaan::select('id_perusahaan', 'nama_perusahaan')
            ->orderBy('nama_perusahaan')
            ->get();

        return view('aset-tetap.create', compact(
            'akun',
            'perusahaan'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_aset'          => 'required|string|max:150',
            'id_akun_aset'       => 'required|exists:akun,id_akun',
            'tanggal_pengadaan'  => 'required|date',
            'nilai_perolehan'    => 'required|numeric|min:0',
            'masa_manfaat'       => 'required|integer|min:1',
            'nilai_sisa'         => 'nullable|numeric|min:0',
            'id_perusahaan'      => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $validated['nilai_sisa'] = $validated['nilai_sisa'] ?? 0;

        // Generate kode aset
        $tanggal = Carbon::parse($validated['tanggal_pengadaan']);
        $prefix  = 'AST-' . $tanggal->format('Ymd');

        $lastAset = AsetTetap::where('kode_aset', 'like', "{$prefix}-%")
            ->latest('id_aset')
            ->first();

        $nomorUrut = $lastAset
            ? (int) substr($lastAset->kode_aset, -4) + 1
            : 1;

        $validated['kode_aset'] = $prefix . '-' . str_pad($nomorUrut, 4, '0', STR_PAD_LEFT);

        DB::beginTransaction();

        try {

            $asetTetap = AsetTetap::create($validated);

            DB::commit();

            return redirect()
                ->route('aset-tetap.index')
                ->with('success', 'Aset tetap berhasil dibuat: ' . $asetTetap->kode_aset);

        } catch (\Throwable $th) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan aset tetap: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AsetTetap $asetTetap)
    {
        $asetTetap->load(['akunAset', 'perusahaan']);

        return view('aset-tetap.show', compact('asetTetap'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AsetTetap $asetTetap)
    {
        $akun = Akun::select('id_akun', 'kode_akun', 'nama_akun')
            ->orderBy('kode_akun')
            ->get();

        $perusahaan = Perusahaan::select('id_perusahaan', 'nama_perusahaan')
            ->orderBy('nama_perusahaan')
            ->get();

        return view('aset-tetap.edit', compact(
            'asetTetap',
            'akun',
            'perusahaan'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AsetTetap $asetTetap)
    {
        $validated = $request->validate([
            'nama_aset'          => 'required|string|max:150',
            'id_akun_aset'       => 'required|exists:akun,id_akun',
            'tanggal_pengadaan'  => 'required|date',
            'nilai_perolehan'    => 'required|numeric|min:0',
            'masa_manfaat'       => 'required|integer|min:1',
            'nilai_sisa'         => 'nullable|numeric|min:0',
            'id_perusahaan'      => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $validated['nilai_sisa'] = $validated['nilai_sisa'] ?? 0;

        DB::beginTransaction();

        try {

            $asetTetap->update([
                'nama_aset'         => $validated['nama_aset'],
                'id_akun_aset'      => $validated['id_akun_aset'],
                'tanggal_pengadaan' => $validated['tanggal_pengadaan'],
                'nilai_perolehan'   => $validated['nilai_perolehan'],
                'masa_manfaat'      => $validated['masa_manfaat'],
                'nilai_sisa'        => $validated['nilai_sisa'],
                'id_perusahaan'     => $validated['id_perusahaan'],
            ]);

            DB::commit();

            return redirect()
                ->route('aset-tetap.index')
                ->with('success', 'Aset tetap berhasil diperbarui');

        } catch (\Throwable $th) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui aset tetap: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AsetTetap $asetTetap)
    {
        DB::beginTransaction();

        try {

            $asetTetap->delete();

            DB::commit();

            return redirect()
                ->route('aset-tetap.index')
                ->with('success', 'Aset tetap berhasil dihapus');

        } catch (\Throwable $th) {

            DB::rollBack();

            return back()
                ->with('error', 'Gagal menghapus aset tetap: ' . $th->getMessage());
        }
    }

    /**
     * Print PDF
     */
    public function print(AsetTetap $asetTetap)
    {
        $asetTetap->load(['akunAset', 'perusahaan']);

        $pdf = Pdf::loadView('aset-tetap.print', compact('asetTetap'))
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('aset-tetap-' . $asetTetap->kode_aset . '.pdf');
    }
}