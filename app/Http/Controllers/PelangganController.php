<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pelanggan::query()
            ->select([
                'id_pelanggan',
                'kode_pelanggan',
                'nama_pelanggan',
                'alamat',
                'telepon',
                'email',
                'limit_kredit',
                'id_perusahaan'
            ])
            ->with([
                'perusahaan:id_perusahaan,nama_perusahaan'
            ]);

        // Filter perusahaan
        if ($request->filled('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('kode_pelanggan', 'like', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pelanggan = $query->orderBy('id_pelanggan', 'desc')
                           ->paginate(15)
                           ->withQueryString();

        $perusahaan = Perusahaan::select(
                'id_perusahaan',
                'nama_perusahaan'
            )
            ->orderBy('nama_perusahaan')
            ->get();

        return view('pelanggan.index', compact(
            'pelanggan',
            'perusahaan'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perusahaan = Perusahaan::all();

        return view('pelanggan.create', compact('perusahaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:150',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:100',
            'limit_kredit'   => 'nullable|numeric|min:0',
            'id_perusahaan'  => 'required|exists:perusahaan,id_perusahaan',
        ]);

        // Generate kode pelanggan otomatis
        $lastPelanggan = Pelanggan::orderBy(
            'id_pelanggan',
            'desc'
        )->first();

        if (
            $lastPelanggan &&
            str_starts_with(
                $lastPelanggan->kode_pelanggan,
                'CUST-'
            )
        ) {
            $lastNumber = (int) substr(
                $lastPelanggan->kode_pelanggan,
                5
            );

            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $kodeOtomatis = 'CUST-' .
            str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $data = $request->all();
        $data['kode_pelanggan'] = $kodeOtomatis;

        Pelanggan::create($data);

        return redirect()
            ->route('pelanggan.index')
            ->with(
                'success',
                'Pelanggan berhasil ditambahkan dengan kode ' .
                $kodeOtomatis
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load('perusahaan');

        return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        $perusahaan = Perusahaan::all();

        return view('pelanggan.edit', compact(
            'pelanggan',
            'perusahaan'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        Pelanggan $pelanggan
    ) {
        $request->validate([
            'kode_pelanggan' =>
                'required|string|max:20|unique:pelanggan,kode_pelanggan,' .
                $pelanggan->id_pelanggan .
                ',id_pelanggan',

            'nama_pelanggan' => 'required|string|max:150',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:100',
            'limit_kredit'   => 'nullable|numeric|min:0',
            'id_perusahaan'  => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $pelanggan->update($request->all());

        return redirect()
            ->route('pelanggan.index')
            ->with(
                'success',
                'Data pelanggan berhasil diperbarui'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()
            ->route('pelanggan.index')
            ->with(
                'success',
                'Pelanggan berhasil dihapus'
            );
    }
}
