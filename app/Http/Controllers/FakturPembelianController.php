<?php

namespace App\Http\Controllers;

use App\Models\FakturPembelian;
use App\Models\Jurnal;
use App\Models\Perusahaan;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakturPembelianController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        $query = FakturPembelian::with([
            'supplier',
            'perusahaan',
            'jurnal'
        ]);

        // ======================================================
        // FILTER
        // ======================================================

        if ($request->filled('id_perusahaan')) {
            $query->where(
                'id_perusahaan',
                $request->id_perusahaan
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        // ======================================================
        // SEARCH
        // ======================================================

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nomor_faktur',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('supplier', function ($supplier) use ($search) {

                    $supplier->where(
                        'nama_supplier',
                        'like',
                        "%{$search}%"
                    );

                });
            });
        }

        $fakturPembelian = $query
            ->latest('id_faktur_pembelian')
            ->paginate(15)
            ->withQueryString();

        $perusahaan = Perusahaan::select(
                'id_perusahaan',
                'nama_perusahaan'
            )
            ->orderBy('nama_perusahaan')
            ->get();

        return view(
            'faktur-pembelian.index',
            compact(
                'fakturPembelian',
                'perusahaan'
            )
        );
    }

    /**
     * Show create form
     */
    public function create()
    {
        $supplier = Supplier::select(
                'id_supplier',
                'nama_supplier'
            )
            ->orderBy('nama_supplier')
            ->get();

        $jurnal = $this->getFormattedJurnal();

        $perusahaan = Perusahaan::select(
                'id_perusahaan',
                'nama_perusahaan'
            )
            ->orderBy('nama_perusahaan')
            ->get();

        return view(
            'faktur-pembelian.create',
            compact(
                'supplier',
                'jurnal',
                'perusahaan'
            )
        );
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'       => 'required|date',
            'id_supplier'   => 'required|exists:supplier,id_supplier',
            'id_jurnal'     => 'nullable|exists:jurnal,id_jurnal',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',

            'subtotal'      => 'required|numeric|min:0',
            'ppn'           => 'nullable|numeric|min:0',

            'status'        => 'required|in:Belum Lunas,Lunas,Dibatalkan',
        ]);

        // ======================================================
        // DEFAULT VALUE
        // ======================================================

        $validated['ppn'] = $validated['ppn'] ?? 0;

        $validated['total'] =
            $validated['subtotal'] +
            $validated['ppn'];

        // ======================================================
        // GENERATE NOMOR FAKTUR
        // ======================================================

        $tanggal = Carbon::parse(
            $validated['tanggal']
        );

        $prefix = 'FP-' . $tanggal->format('Ymd');

        $lastFaktur = FakturPembelian::where(
                'nomor_faktur',
                'like',
                "{$prefix}-%"
            )
            ->latest('id_faktur_pembelian')
            ->first();

        $nomorUrut = 1;

        if ($lastFaktur) {

            $explode = explode(
                '-',
                $lastFaktur->nomor_faktur
            );

            $nomorUrut =
                (int) end($explode) + 1;
        }

        $validated['nomor_faktur'] =
            $prefix . '-' .
            str_pad(
                $nomorUrut,
                4,
                '0',
                STR_PAD_LEFT
            );

        DB::beginTransaction();

        try {

            $fakturPembelian =
                FakturPembelian::create($validated);

            DB::commit();

            return redirect()
                ->route('faktur-pembelian.index')
                ->with(
                    'success',
                    'Faktur berhasil dibuat : '
                    . $fakturPembelian->nomor_faktur
                );

        } catch (\Throwable $th) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal menyimpan data : '
                    . $th->getMessage()
                );
        }
    }

    /**
     * Detail data
     */
    public function show(FakturPembelian $fakturPembelian)
    {
        $fakturPembelian->load([
            'supplier',
            'perusahaan',
            'jurnal'
        ]);

        return view(
            'faktur-pembelian.show',
            compact('fakturPembelian')
        );
    }

    /**
     * Edit form
     */
    public function edit(FakturPembelian $fakturPembelian)
    {
        $supplier = Supplier::select(
                'id_supplier',
                'nama_supplier'
            )
            ->orderBy('nama_supplier')
            ->get();

        $jurnal = $this->getFormattedJurnal();

        $perusahaan = Perusahaan::select(
                'id_perusahaan',
                'nama_perusahaan'
            )
            ->orderBy('nama_perusahaan')
            ->get();

        return view(
            'faktur-pembelian.edit',
            compact(
                'fakturPembelian',
                'supplier',
                'jurnal',
                'perusahaan'
            )
        );
    }

    /**
     * Update data
     */
    public function update(
        Request $request,
        FakturPembelian $fakturPembelian
    ) {

        $validated = $request->validate([
            'tanggal'       => 'required|date',
            'id_supplier'   => 'required|exists:supplier,id_supplier',
            'id_jurnal'     => 'nullable|exists:jurnal,id_jurnal',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',

            'subtotal'      => 'required|numeric|min:0',
            'ppn'           => 'nullable|numeric|min:0',

            'status'        => 'required|in:Belum Lunas,Lunas,Dibatalkan',
        ]);

        $validated['ppn'] =
            $validated['ppn'] ?? 0;

        $validated['total'] =
            $validated['subtotal'] +
            $validated['ppn'];

        DB::beginTransaction();

        try {

            $fakturPembelian->update($validated);

            DB::commit();

            return redirect()
                ->route('faktur-pembelian.index')
                ->with(
                    'success',
                    'Faktur berhasil diperbarui'
                );

        } catch (\Throwable $th) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal update data : '
                    . $th->getMessage()
                );
        }
    }

    /**
     * Delete data
     */
    public function destroy(FakturPembelian $fakturPembelian)
    {
        DB::beginTransaction();

        try {

            $fakturPembelian->delete();

            DB::commit();

            return redirect()
                ->route('faktur-pembelian.index')
                ->with(
                    'success',
                    'Faktur berhasil dihapus'
                );

        } catch (\Throwable $th) {

            DB::rollBack();

            return back()->with(
                'error',
                'Gagal menghapus data : '
                . $th->getMessage()
            );
        }
    }

    /**
     * Print faktur
     */
    public function print(FakturPembelian $fakturPembelian)
    {
        $fakturPembelian->load([
            'supplier',
            'perusahaan',
            'jurnal'
        ]);

        return view(
            'faktur-pembelian.print',
            compact('fakturPembelian')
        );
    }

    /**
     * Format jurnal dropdown
     */
    private function getFormattedJurnal()
    {
        return Jurnal::select(
                'id_jurnal',
                'nomor_jurnal',
                'keterangan'
            )
            ->orderBy('nomor_jurnal')
            ->get()
            ->map(function ($jurnal) {

                return [
                    'id' => $jurnal->id_jurnal,

                    'text' =>
                        $jurnal->nomor_jurnal .
                        ' - ' .
                        ($jurnal->keterangan ?? '-'),
                ];
            });
    }
}