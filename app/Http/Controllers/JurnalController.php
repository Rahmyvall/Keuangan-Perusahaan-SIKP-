<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Periode;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JurnalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TIPE JURNAL
    |--------------------------------------------------------------------------
    */
    private $tipeJurnal = [
        'Umum',
        'Penyesuaian',
        'Penutup',
        'Pembalik',
        'Kas Masuk',
        'Kas Keluar',
        'Bank'
    ];

    /**
     * LIST DATA
     */
    public function index(Request $request)
    {
        $query = Jurnal::query()
            ->select([
                'id_jurnal',
                'nomor_jurnal',
                'tanggal',
                'deskripsi',
                'tipe_jurnal',
                'id_periode',
                'id_perusahaan',
                'posted',
                'approved_by',
                'approved_at',
                'created_by',
            ])
            ->with([
                'periode:id_periode,nama_periode,tahun',
                'perusahaan:id_perusahaan,nama_perusahaan',
                'creator:id_pengguna,nama_pengguna',
                'approver:id_pengguna,nama_pengguna',
            ])
            ->orderByDesc('tanggal')
            ->orderByDesc('id_jurnal');

        /*
        |--------------------------------------------------------------------------
        | FILTER PERIODE
        |--------------------------------------------------------------------------
        */
        if ($request->filled('periode')) {

            $query->where(
                'id_periode',
                $request->periode
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TIPE JURNAL
        |--------------------------------------------------------------------------
        */
        if ($request->filled('tipe')) {

            $query->where(
                'tipe_jurnal',
                $request->tipe
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER POSTED
        |--------------------------------------------------------------------------
        */
        if ($request->filled('posted')) {

            $query->where(
                'posted',
                filter_var(
                    $request->posted,
                    FILTER_VALIDATE_BOOLEAN
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nomor_jurnal',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'deskripsi',
                    'like',
                    "%{$search}%"
                );
            });
        }

        $jurnals = $query
            ->paginate(15)
            ->withQueryString();

        $periodes = Periode::orderByDesc('tahun')
            ->get();

        $tipeJurnal = $this->tipeJurnal;

        return view('jurnal.index', compact(
            'jurnals',
            'periodes',
            'tipeJurnal'
        ));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        $periodes = Periode::where(
                'is_active',
                true
            )
            ->orderByDesc('tahun')
            ->get();

        $perusahaans = Perusahaan::orderBy(
                'nama_perusahaan'
            )
            ->get();

        $tipeJurnal = $this->tipeJurnal;

        return view('jurnal.create', compact(
            'periodes',
            'perusahaans',
            'tipeJurnal'
        ));
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'nomor_jurnal' =>
                'required|string|max:50|unique:jurnal,nomor_jurnal',

            'tanggal' =>
                'required|date',

            'deskripsi' =>
                'required|string',

            'tipe_jurnal' =>
                'required|in:' . implode(',', $this->tipeJurnal),

            'id_periode' =>
                'required|exists:periode,id_periode',

            'id_perusahaan' =>
                'required|exists:perusahaan,id_perusahaan',
        ]);

        $validated['created_by'] = Auth::id();

        $validated['posted'] = false;

        DB::beginTransaction();

        try {

            $jurnal = Jurnal::create($validated);

            DB::commit();

            return redirect()
                ->route('jurnal.index')
                ->with(
                    'success',
                    'Jurnal berhasil dibuat: ' .
                    $jurnal->nomor_jurnal
                );

        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal menyimpan jurnal'
                );
        }
    }

    /**
     * SHOW
     */
    public function show(Jurnal $jurnal)
    {
        $jurnal->load([
            'periode',
            'perusahaan',
            'creator',
            'approver',
            'details.akun'
        ]);

        return view(
            'jurnal.show',
            compact('jurnal')
        );
    }

    /**
     * FORM EDIT
     */
    public function edit(Jurnal $jurnal)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI POSTED
        |--------------------------------------------------------------------------
        */
        if ($jurnal->posted) {

            return redirect()
                ->route('jurnal.index')
                ->with(
                    'error',
                    'Jurnal yang sudah diposting tidak dapat diedit'
                );
        }

        $periodes = Periode::orderByDesc('tahun')
            ->get();

        $perusahaans = Perusahaan::orderBy(
                'nama_perusahaan'
            )
            ->get();

        $tipeJurnal = $this->tipeJurnal;

        return view('jurnal.edit', compact(
            'jurnal',
            'periodes',
            'perusahaans',
            'tipeJurnal'
        ));
    }

    /**
     * UPDATE
     */
    public function update(
        Request $request,
        Jurnal $jurnal
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI POSTED
        |--------------------------------------------------------------------------
        */
        if ($jurnal->posted) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jurnal yang sudah diposting tidak dapat diubah'
                );
        }

        $validated = $request->validate([

            'nomor_jurnal' =>
                'required|string|max:50|unique:jurnal,nomor_jurnal,' .
                $jurnal->id_jurnal .
                ',id_jurnal',

            'tanggal' =>
                'required|date',

            'deskripsi' =>
                'required|string',

            'tipe_jurnal' =>
                'required|in:' . implode(',', $this->tipeJurnal),

            'id_periode' =>
                'required|exists:periode,id_periode',

            'id_perusahaan' =>
                'required|exists:perusahaan,id_perusahaan',
        ]);

        DB::beginTransaction();

        try {

            $jurnal->update($validated);

            DB::commit();

            return redirect()
                ->route('jurnal.index')
                ->with(
                    'success',
                    'Jurnal berhasil diperbarui'
                );

        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal memperbarui jurnal'
                );
        }
    }

    /**
     * DELETE
     */
    public function destroy(Jurnal $jurnal)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI POSTED
        |--------------------------------------------------------------------------
        */
        if ($jurnal->posted) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jurnal yang sudah diposting tidak dapat dihapus'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI RELASI
        |--------------------------------------------------------------------------
        */
        if ($jurnal->fakturPenjualan()->count() > 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jurnal sudah digunakan pada faktur penjualan'
                );
        }

        DB::beginTransaction();

        try {

            $jurnal->details()->delete();

            $jurnal->delete();

            DB::commit();

            return redirect()
                ->route('jurnal.index')
                ->with(
                    'success',
                    'Jurnal berhasil dihapus'
                );

        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Gagal menghapus jurnal'
                );
        }
    }

    /**
     * POST JURNAL
     */
    public function post(Jurnal $jurnal)
    {
        if ($jurnal->posted) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jurnal sudah diposting'
                );
        }

        $jurnal->update([
            'posted' => true
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Jurnal berhasil diposting'
            );
    }

    /**
     * UNPOST JURNAL
     */
    public function unpost(Jurnal $jurnal)
    {
        $jurnal->update([
            'posted' => false
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Jurnal berhasil di-unpost'
            );
    }

    /**
     * APPROVE JURNAL
     */
    public function approve(Jurnal $jurnal)
    {
        $jurnal->update([
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Jurnal berhasil di-approve'
            );
    }

    /**
     * REJECT APPROVAL
     */
    public function reject(Jurnal $jurnal)
    {
        $jurnal->update([
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Approval jurnal berhasil dibatalkan'
            );
    }
}
