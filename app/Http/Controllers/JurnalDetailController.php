<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\Akun;
use App\Models\MataUang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalDetailController extends Controller
{
    /**
     * Menampilkan daftar detail jurnal (untuk satu jurnal tertentu)
     */
    public function index(Request $request, Jurnal $jurnal)
{
    $details = JurnalDetail::where('id_jurnal', $jurnal->id_jurnal)
                ->with(['akun'])
                ->get();

    return view('jurnal.detail.index', compact('jurnal', 'details'));
}

    /**
     * Form Tambah Detail Baru
     */
    public function create(Jurnal $jurnal)
    {
        if ($jurnal->posted) {
            return redirect()
                ->route('jurnal.show', $jurnal)
                ->with('error', 'Jurnal sudah diposting, tidak dapat menambah detail');
        }

        $akuns = Akun::where('is_active', true)
                ->orderBy('kode_akun')
                ->get();

        $mataUangs = MataUang::orderBy('kode_mata_uang')->get();

        return view('jurnal.detail.create', compact('jurnal', 'akuns', 'mataUangs'));
    }

    /**
     * Simpan Detail Baru
     */
    public function store(Request $request, Jurnal $jurnal)
    {
        if ($jurnal->posted) {
            return redirect()
                ->back()
                ->with('error', 'Jurnal sudah diposting');
        }

        $validated = $request->validate([
            'id_akun'       => 'required|exists:akun,id_akun',
            'debit'         => 'required|numeric|min:0',
            'kredit'        => 'required|numeric|min:0',
            'keterangan'    => 'nullable|string|max:255',
            'id_mata_uang'  => 'nullable|exists:mata_uang,id_mata_uang',
            'kurs'          => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            JurnalDetail::create([
                'id_jurnal'     => $jurnal->id_jurnal,
                'id_akun'       => $validated['id_akun'],
                'debit'         => $validated['debit'],
                'kredit'        => $validated['kredit'],
                'keterangan'    => $validated['keterangan'],
                'id_mata_uang'  => $validated['id_mata_uang'] ?? 1,
                'kurs'          => $validated['kurs'] ?? 1.0000,
            ]);

            DB::commit();

            return redirect()
                ->route('jurnal.detail.index', $jurnal)
                ->with('success', 'Detail jurnal berhasil ditambahkan');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan detail jurnal');
        }
    }

    /**
     * Form Edit Detail
     */
    public function edit(Jurnal $jurnal, JurnalDetail $detail)
    {
        if ($jurnal->posted || $detail->id_jurnal !== $jurnal->id_jurnal) {
            return redirect()->route('jurnal.show', $jurnal)
                ->with('error', 'Tidak dapat mengedit detail');
        }

        $akuns = Akun::where('is_active', true)->orderBy('kode_akun')->get();
        $mataUangs = MataUang::orderBy('kode_mata_uang')->get();

        return view('jurnal.detail.edit', compact('jurnal', 'detail', 'akuns', 'mataUangs'));
    }

    /**
     * Update Detail
     */
    public function update(Request $request, Jurnal $jurnal, JurnalDetail $detail)
    {
        if ($jurnal->posted || $detail->id_jurnal !== $jurnal->id_jurnal) {
            return redirect()->back()->with('error', 'Tidak dapat mengubah detail');
        }

        $validated = $request->validate([
            'id_akun'       => 'required|exists:akun,id_akun',
            'debit'         => 'required|numeric|min:0',
            'kredit'        => 'required|numeric|min:0',
            'keterangan'    => 'nullable|string|max:255',
            'id_mata_uang'  => 'nullable|exists:mata_uang,id_mata_uang',
            'kurs'          => 'nullable|numeric|min:0',
        ]);

        $detail->update([
            'id_akun'       => $validated['id_akun'],
            'debit'         => $validated['debit'],
            'kredit'        => $validated['kredit'],
            'keterangan'    => $validated['keterangan'],
            'id_mata_uang'  => $validated['id_mata_uang'] ?? 1,
            'kurs'          => $validated['kurs'] ?? 1.0000,
        ]);

        return redirect()
            ->route('jurnal.detail.index', $jurnal)
            ->with('success', 'Detail jurnal berhasil diperbarui');
    }

    /**
     * Hapus Detail
     */
    public function destroy(Jurnal $jurnal, JurnalDetail $detail)
    {
        if ($jurnal->posted || $detail->id_jurnal !== $jurnal->id_jurnal) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus detail');
        }

        $detail->delete();

        return redirect()
            ->route('jurnal.detail.index', $jurnal)
            ->with('success', 'Detail jurnal berhasil dihapus');
    }

    /**
     * Bulk Update (Replace Semua Detail)
     * Berguna jika ingin mengganti semua detail sekaligus
     */
    public function bulkUpdate(Request $request, Jurnal $jurnal)
    {
        if ($jurnal->posted) {
            return redirect()->back()->with('error', 'Jurnal sudah diposting');
        }

        $request->validate([
            'details' => 'required|array|min:2',
            'details.*.id_akun' => 'required|exists:akun,id_akun',
            'details.*.debit'   => 'required|numeric|min:0',
            'details.*.kredit'  => 'required|numeric|min:0',
            'details.*.keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Hapus semua detail lama
            $jurnal->details()->delete();

            $totalDebit = 0;
            $totalKredit = 0;

            foreach ($request->details as $item) {
                JurnalDetail::create([
                    'id_jurnal'     => $jurnal->id_jurnal,
                    'id_akun'       => $item['id_akun'],
                    'debit'         => $item['debit'],
                    'kredit'        => $item['kredit'],
                    'keterangan'    => $item['keterangan'] ?? null,
                    'id_mata_uang'  => $item['id_mata_uang'] ?? 1,
                    'kurs'          => $item['kurs'] ?? 1.0000,
                ]);

                $totalDebit  += (float)$item['debit'];
                $totalKredit += (float)$item['kredit'];
            }

            if (abs($totalDebit - $totalKredit) > 0.01) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Jurnal tidak balance! Total Debit dan Kredit harus sama.');
            }

            DB::commit();

            return redirect()
                ->route('jurnal.detail.index', $jurnal)
                ->with('success', 'Semua detail jurnal berhasil diperbarui');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan detail jurnal');
        }
    }
}