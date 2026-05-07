<?php

namespace App\Http\Controllers;

use App\Models\FakturPenjualan;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FakturPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = FakturPenjualan::query()
            ->select([
                'id_faktur_penjualan',
                'nomor_faktur',
                'tanggal',
                'id_pelanggan',
                'id_jurnal',
                'subtotal',
                'ppn',
                'total',
                'status',
                'id_perusahaan'
            ])
            ->with([
                'pelanggan:id_pelanggan,nama_pelanggan',
                'perusahaan:id_perusahaan,nama_perusahaan',
                'jurnal:id_jurnal,nomor_jurnal,keterangan'
            ]);

        if ($request->filled('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nomor_faktur', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function ($pelanggan) use ($search) {
                      $pelanggan->where('nama_pelanggan', 'like', "%{$search}%");
                  });
            });
        }

        $fakturPenjualan = $query
            ->orderBy('id_faktur_penjualan', 'desc')
            ->paginate(15)
            ->withQueryString();

        $perusahaan = Perusahaan::select('id_perusahaan', 'nama_perusahaan')
            ->orderBy('nama_perusahaan')
            ->get();

        return view('faktur_penjualan.index', compact('fakturPenjualan', 'perusahaan'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::select('id_pelanggan', 'nama_pelanggan')
            ->orderBy('nama_pelanggan')
            ->get();

        $jurnal = Jurnal::select('id_jurnal', 'nomor_jurnal', 'keterangan', 'tanggal')
            ->orderBy('id_jurnal', 'desc')
            ->get()
            ->map(function ($item) {
                $label = $item->nomor_jurnal
                            ? $item->nomor_jurnal
                            : '#' . str_pad($item->id_jurnal, 6, '0', STR_PAD_LEFT);

                if ($item->keterangan) {
                    $label .= ' - ' . Str::limit($item->keterangan, 65);
                }

                if ($item->tanggal) {
                    $label .= ' (' . Carbon::parse($item->tanggal)->format('d M Y') . ')';
                }

                $item->formatted_label = $label;
                return $item;
            });

        $perusahaan = Perusahaan::select('id_perusahaan', 'nama_perusahaan')
            ->orderBy('nama_perusahaan')
            ->get();

        return view('faktur_penjualan.create', compact('pelanggan', 'jurnal', 'perusahaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'       => 'required|date',
            'id_pelanggan'  => 'required|exists:pelanggan,id_pelanggan',
            'id_jurnal'     => 'nullable|exists:jurnal,id_jurnal',
            'subtotal'      => 'required|numeric|min:0',
            'ppn'           => 'nullable|numeric|min:0',
            'total'         => 'required|numeric|min:0',
            'status'        => 'required|in:Belum Lunas,Lunas,Dibatalkan',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        DB::beginTransaction();

        try {
            $lastFaktur = FakturPenjualan::orderBy('id_faktur_penjualan', 'desc')->first();

            if ($lastFaktur && str_starts_with($lastFaktur->nomor_faktur, 'INV-')) {
                $lastNumber = (int) substr($lastFaktur->nomor_faktur, 4);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $nomorFaktur = 'INV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            FakturPenjualan::create([
                'nomor_faktur'  => $nomorFaktur,
                'tanggal'       => $request->tanggal,
                'id_pelanggan'  => $request->id_pelanggan,
                'id_jurnal'     => $request->id_jurnal,
                'subtotal'      => $request->subtotal,
                'ppn'           => $request->ppn ?? 0,
                'total'         => $request->total,
                'status'        => $request->status,
                'id_perusahaan' => $request->id_perusahaan,
            ]);

            DB::commit();

            return redirect()->route('faktur-penjualan.index')
                ->with('success', 'Faktur penjualan berhasil ditambahkan dengan nomor ' . $nomorFaktur);

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan faktur penjualan');
        }
    }

    /**
     * Display the specified resource.  ← METHOD INI YANG DITAMBAHKAN
     */
    public function show(FakturPenjualan $fakturPenjualan)
    {
        $fakturPenjualan->load([
            'pelanggan',
            'perusahaan',
            'jurnal'
        ]);

        return view('faktur_penjualan.show', compact('fakturPenjualan'));
    }

    public function edit(FakturPenjualan $fakturPenjualan)
    {
        $pelanggan = Pelanggan::select('id_pelanggan', 'nama_pelanggan')
            ->orderBy('nama_pelanggan')
            ->get();

        $jurnal = Jurnal::select('id_jurnal', 'nomor_jurnal', 'keterangan', 'tanggal')
            ->orderBy('id_jurnal', 'desc')
            ->get()
            ->map(function ($item) {
                $label = $item->nomor_jurnal
                            ? $item->nomor_jurnal
                            : '#' . str_pad($item->id_jurnal, 6, '0', STR_PAD_LEFT);

                if ($item->keterangan) {
                    $label .= ' - ' . Str::limit($item->keterangan, 65);
                }

                if ($item->tanggal) {
                    $label .= ' (' . Carbon::parse($item->tanggal)->format('d M Y') . ')';
                }

                $item->formatted_label = $label;
                return $item;
            });

        $perusahaan = Perusahaan::select('id_perusahaan', 'nama_perusahaan')
            ->orderBy('nama_perusahaan')
            ->get();

        return view('faktur_penjualan.edit', compact(
            'fakturPenjualan',
            'pelanggan',
            'jurnal',
            'perusahaan'
        ));
    }

    public function update(Request $request, FakturPenjualan $fakturPenjualan)
    {
        $request->validate([
            'nomor_faktur'  => 'required|string|max:50|unique:faktur_penjualan,nomor_faktur,' .
                              $fakturPenjualan->id_faktur_penjualan . ',id_faktur_penjualan',
            'tanggal'       => 'required|date',
            'id_pelanggan'  => 'required|exists:pelanggan,id_pelanggan',
            'id_jurnal'     => 'nullable|exists:jurnal,id_jurnal',
            'subtotal'      => 'required|numeric|min:0',
            'ppn'           => 'nullable|numeric|min:0',
            'total'         => 'required|numeric|min:0',
            'status'        => 'required|in:Belum Lunas,Lunas,Dibatalkan',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        DB::beginTransaction();

        try {
            $fakturPenjualan->update([
                'nomor_faktur'  => $request->nomor_faktur,
                'tanggal'       => $request->tanggal,
                'id_pelanggan'  => $request->id_pelanggan,
                'id_jurnal'     => $request->id_jurnal,
                'subtotal'      => $request->subtotal,
                'ppn'           => $request->ppn ?? 0,
                'total'         => $request->total,
                'status'        => $request->status,
                'id_perusahaan' => $request->id_perusahaan,
            ]);

            DB::commit();

            return redirect()->route('faktur-penjualan.index')
                ->with('success', 'Data faktur penjualan berhasil diperbarui');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui faktur penjualan');
        }
    }

    public function destroy(FakturPenjualan $fakturPenjualan)
    {
        try {
            $fakturPenjualan->delete();
            return redirect()->route('faktur-penjualan.index')
                ->with('success', 'Faktur penjualan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus faktur penjualan');
        }
    }

    public function updateStatus(Request $request, FakturPenjualan $fakturPenjualan)
    {
        $request->validate([
            'status' => 'required|in:Belum Lunas,Lunas,Dibatalkan'
        ]);

        $fakturPenjualan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status faktur berhasil diperbarui');
    }
}
