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
    /**
     * LIST DATA
     */
    public function index(Request $request)
    {
        $query = Jurnal::with(['periode', 'perusahaan', 'creator', 'approver'])
            ->orderByDesc('tanggal')
            ->orderByDesc('id_jurnal');

        // Filter periode
        if ($request->filled('periode')) {
            $query->where('id_periode', $request->periode);
        }

        // Filter tipe jurnal
        if ($request->filled('tipe')) {
            $query->where('tipe_jurnal', $request->tipe);
        }

        // Filter posted
        if ($request->filled('posted')) {
            $query->where('posted', filter_var($request->posted, FILTER_VALIDATE_BOOLEAN));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_jurnal', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $jurnals = $query->paginate(15);

        $periodes = Periode::orderByDesc('tahun')->get();

        $tipeJurnal = [
            'Umum',
            'Penyesuaian',
            'Penutup',
            'Pembalik',
            'Kas Masuk',
            'Kas Keluar',
            'Bank'
        ];

        return view('jurnal.index', compact('jurnals', 'periodes', 'tipeJurnal'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        $periodes = Periode::where('is_active', true)
            ->orderByDesc('tahun')
            ->get();

        $perusahaans = Perusahaan::all();

        $tipeJurnal = [
            'Umum',
            'Penyesuaian',
            'Penutup',
            'Pembalik',
            'Kas Masuk',
            'Kas Keluar',
            'Bank'
        ];

        return view('jurnal.create', compact('periodes', 'perusahaans', 'tipeJurnal'));
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_jurnal'  => 'required|string|max:50|unique:jurnal,nomor_jurnal',
            'tanggal'       => 'required|date',
            'deskripsi'     => 'required|string',
            'tipe_jurnal'   => 'required|in:Umum,Penyesuaian,Penutup,Pembalik,Kas Masuk,Kas Keluar,Bank',
            'id_periode'    => 'required|exists:periode,id_periode',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['posted'] = false;

        DB::beginTransaction();

        try {
            $jurnal = Jurnal::create($validated);

            DB::commit();

            return redirect()
                ->route('jurnal.index')
                ->with('success', 'Jurnal berhasil dibuat: ' . $jurnal->nomor_jurnal);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menyimpan jurnal: ' . $e->getMessage());
        }
    }

    /**
     * SHOW
     */
    public function show(Jurnal $jurnal)
    {
        $jurnal->load(['periode', 'perusahaan', 'creator', 'approver']);

        return view('jurnal.show', compact('jurnal'));
    }

    /**
     * EDIT
     */
    public function edit(Jurnal $jurnal)
    {
        if ($jurnal->posted) {
            return redirect()
                ->route('jurnal.index')
                ->with('error', 'Jurnal yang sudah diposting tidak dapat diedit');
        }

        $periodes = Periode::orderByDesc('tahun')->get();
        $perusahaans = Perusahaan::all();

        $tipeJurnal = [
            'Umum',
            'Penyesuaian',
            'Penutup',
            'Pembalik',
            'Kas Masuk',
            'Kas Keluar',
            'Bank'
        ];

        return view('jurnal.edit', compact('jurnal', 'periodes', 'perusahaans', 'tipeJurnal'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        if ($jurnal->posted) {
            return back()->with('error', 'Jurnal yang sudah diposting tidak dapat diubah');
        }

        $validated = $request->validate([
            'nomor_jurnal'  => 'required|string|max:50|unique:jurnal,nomor_jurnal,' . $jurnal->id_jurnal . ',id_jurnal',
            'tanggal'       => 'required|date',
            'deskripsi'     => 'required|string',
            'tipe_jurnal'   => 'required|in:Umum,Penyesuaian,Penutup,Pembalik,Kas Masuk,Kas Keluar,Bank',
            'id_periode'    => 'required|exists:periode,id_periode',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $jurnal->update($validated);

        return redirect()
            ->route('jurnal.index')
            ->with('success', 'Jurnal berhasil diperbarui');
    }

    /**
     * DELETE
     */
    public function destroy(Jurnal $jurnal)
    {
        if ($jurnal->posted) {
            return back()->with('error', 'Jurnal yang sudah diposting tidak dapat dihapus');
        }

        $jurnal->delete();

        return redirect()
            ->route('jurnal.index')
            ->with('success', 'Jurnal berhasil dihapus');
    }

    /**
     * POST / UNPOST
     */
    public function post(Jurnal $jurnal)
    {
        $jurnal->update(['posted' => true]);

        return back()->with('success', 'Jurnal berhasil diposting');
    }

    public function unpost(Jurnal $jurnal)
    {
        $jurnal->update(['posted' => false]);

        return back()->with('success', 'Jurnal berhasil di-unpost');
    }

    /**
     * APPROVE
     */
    public function approve(Jurnal $jurnal)
    {
        $jurnal->update([
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Jurnal berhasil di-approve');
    }
}
