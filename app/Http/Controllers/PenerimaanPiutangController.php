<?php

namespace App\Http\Controllers;

use App\Models\PenerimaanPiutang;
use App\Models\FakturPenjualan;
use App\Models\Perusahaan;
use App\Models\Jurnal;
use App\Http\Requests\StorePenerimaanPiutangRequest;
use App\Http\Requests\UpdatePenerimaanPiutangRequest;
use Illuminate\Http\Request;

class PenerimaanPiutangController extends Controller
{
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

        return view('penerimaan-piutang.index', compact('data'));
    }

    public function create()
    {
        $faktur     = FakturPenjualan::all();
        $perusahaan = Perusahaan::all();
        $jurnal     = Jurnal::orderBy('nomor_jurnal')->get();   // ← Tambahan penting

        // Generate nomor penerimaan otomatis
        $nomorPenerimaan = $this->generateNomorPenerimaan();

        return view('penerimaan-piutang.create', compact(
            'faktur',
            'perusahaan',
            'jurnal',
            'nomorPenerimaan'
        ));
    }

    public function store(StorePenerimaanPiutangRequest $request)
    {
        $data = $request->validated();

        // Jika nomor kosong, generate otomatis
        if (empty($data['nomor_penerimaan'])) {
            $data['nomor_penerimaan'] = $this->generateNomorPenerimaan();
        }

        PenerimaanPiutang::create($data);

        return redirect()->route('penerimaan-piutang.index')
                         ->with('success', 'Penerimaan piutang berhasil dibuat dengan nomor ' . $data['nomor_penerimaan']);
    }

    public function show($id)
    {
        $penerimaanPiutang = PenerimaanPiutang::with(['fakturPenjualan', 'jurnal', 'perusahaan'])
                            ->findOrFail($id);

        return view('penerimaan-piutang.show', compact('penerimaanPiutang'));
    }

    public function edit($id)
{
    // Ambil data penerimaan beserta relasinya
    $penerimaanPiutang = PenerimaanPiutang::with([
            'fakturPenjualan',
            'perusahaan',
            'jurnal'
        ])
        ->findOrFail($id);

    // Data untuk dropdown
    $faktur     = FakturPenjualan::orderBy('nomor_faktur')->get();
    $perusahaan = Perusahaan::orderBy('nama_perusahaan')->get();
    $jurnal     = Jurnal::orderBy('nomor_jurnal')->get();

    return view('penerimaan-piutang.edit', compact(
        'penerimaanPiutang',
        'faktur',
        'perusahaan',
        'jurnal'
    ));
}

    public function update(UpdatePenerimaanPiutangRequest $request, $id)
    {
        $penerimaanPiutang = PenerimaanPiutang::findOrFail($id);
        $penerimaanPiutang->update($request->validated());

        return redirect()->route('penerimaan-piutang.index')
                         ->with('success', 'Penerimaan piutang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penerimaanPiutang = PenerimaanPiutang::findOrFail($id);
        $penerimaanPiutang->delete();

        return redirect()->route('penerimaan-piutang.index')
                         ->with('success', 'Penerimaan piutang berhasil dihapus.');
    }

    /**
     * Generate Nomor Penerimaan Otomatis
     * Format: RCV-YYYYMMDD-001
     */
    private function generateNomorPenerimaan()
    {
        $prefix = 'RCV';
        $date = now()->format('Ymd');

        $lastRecord = PenerimaanPiutang::where('nomor_penerimaan', 'like', "{$prefix}-{$date}-%")
                        ->orderBy('nomor_penerimaan', 'desc')
                        ->first();

        if ($lastRecord) {
            $lastNumber = (int) substr($lastRecord->nomor_penerimaan, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "{$prefix}-{$date}-{$newNumber}";
    }
}