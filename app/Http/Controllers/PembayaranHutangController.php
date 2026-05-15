<?php

namespace App\Http\Controllers;

use App\Models\PembayaranHutang;
use App\Models\FakturPembelian;
use App\Models\Jurnal;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranHutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PembayaranHutang::with(['fakturPembelian','jurnal','perusahaan'])->latest('id_pembayaran');

        // Filter search
        if ($request->search) {
            $query->where('nomor_pembayaran', 'like', "%{$request->search}%");
        }

        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Pagination 10 per halaman, withQueryString supaya filter tetap
        $data = $query->paginate(10)->withQueryString();

        return view('pembayaran_hutang.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $fakturPembelian = FakturPembelian::all();
    $jurnal = Jurnal::all();
    $perusahaan = Perusahaan::all();

    // Generate Nomor Pembayaran otomatis
    $today = date('Ymd');
    $last = PembayaranHutang::whereDate('tanggal', date('Y-m-d'))->orderBy('id_pembayaran', 'desc')->first();

    if ($last) {
        // Ambil nomor terakhir, misal PH-20260515-0001
        $lastNumber = (int) substr($last->nomor_pembayaran, -4);
        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $nextNumber = '0001';
    }

    $nomorPembayaran = 'PH-' . $today . '-' . $nextNumber;

    return view('pembayaran_hutang.create', compact(
        'fakturPembelian',
        'jurnal',
        'perusahaan',
        'nomorPembayaran'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_pembayaran'    => 'required|max:50|unique:pembayaran_hutang,nomor_pembayaran',
            'tanggal'             => 'required|date',
            'id_faktur_pembelian' => 'required|exists:faktur_pembelian,id_faktur_pembelian',
            'id_jurnal'           => 'nullable|exists:jurnal,id_jurnal',
            'jumlah'              => 'required|numeric|min:0',
            'id_perusahaan'       => 'required|exists:perusahaan,id_perusahaan',
        ]);

        DB::beginTransaction();
        try {
            PembayaranHutang::create($request->only([
                'nomor_pembayaran',
                'tanggal',
                'id_faktur_pembelian',
                'id_jurnal',
                'jumlah',
                'id_perusahaan'
            ]));
            DB::commit();

            return redirect()->route('pembayaran-hutang.index')->with('success', 'Pembayaran hutang berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pembayaran hutang');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pembayaranHutang = PembayaranHutang::findOrFail($id);

        $fakturPembelian = FakturPembelian::all();
        $jurnal = Jurnal::all();
        $perusahaan = Perusahaan::all();

        return view('pembayaran_hutang.edit', compact(
            'pembayaranHutang',
            'fakturPembelian',
            'jurnal',
            'perusahaan'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pembayaranHutang = PembayaranHutang::findOrFail($id);

        $request->validate([
            'nomor_pembayaran'    => 'required|max:50|unique:pembayaran_hutang,nomor_pembayaran,' . $id . ',id_pembayaran',
            'tanggal'             => 'required|date',
            'id_faktur_pembelian' => 'required|exists:faktur_pembelian,id_faktur_pembelian',
            'id_jurnal'           => 'nullable|exists:jurnal,id_jurnal',
            'jumlah'              => 'required|numeric|min:0',
            'id_perusahaan'       => 'required|exists:perusahaan,id_perusahaan',
        ]);

        DB::beginTransaction();
        try {
            $pembayaranHutang->update($request->only([
                'nomor_pembayaran',
                'tanggal',
                'id_faktur_pembelian',
                'id_jurnal',
                'jumlah',
                'id_perusahaan'
            ]));
            DB::commit();

            return redirect()->route('pembayaran-hutang.index')->with('success', 'Pembayaran hutang berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal update pembayaran hutang');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pembayaranHutang = PembayaranHutang::findOrFail($id);

        DB::beginTransaction();
        try {
            $pembayaranHutang->delete();
            DB::commit();

            return redirect()->route('pembayaran-hutang.index')->with('success', 'Pembayaran hutang berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus pembayaran hutang');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pembayaranHutang = PembayaranHutang::with(['fakturPembelian','jurnal','perusahaan'])->findOrFail($id);

        return view('pembayaran_hutang.show', compact('pembayaranHutang'));
    }
}