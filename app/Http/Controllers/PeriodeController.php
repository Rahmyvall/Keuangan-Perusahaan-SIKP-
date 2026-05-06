<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;

class PeriodeController extends Controller
{
    public function index(Request $request)
    {
        $query = Periode::with('perusahaan'); // eager loading relasi perusahaan

        // ====================== SEARCH ======================
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tahun', 'like', "%{$search}%")
                  ->orWhere('bulan', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(tahun, '-', LPAD(bulan, 2, '0')) LIKE ?", ["%{$search}%"])
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('perusahaan', function($pq) use ($search) {
                      $pq->where('nama_perusahaan', 'like', "%{$search}%");
                  });
            });
        }

        // ====================== FILTER STATUS ======================
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ====================== FILTER PERUSAHAAN ======================
        if ($request->filled('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        // ====================== SORTING ======================
        $sort = $request->get('sort', 'tahun');
        $direction = $request->get('direction', 'desc');

        // Kolom sorting yang diizinkan (security)
        $allowedSort = ['id_periode', 'tahun', 'bulan', 'tanggal_awal', 'tanggal_akhir', 'status', 'created_at'];
        if (!in_array($sort, $allowedSort)) {
            $sort = 'tahun';
        }

        $periode = $query->orderBy($sort, $direction)
                         ->orderBy('bulan', 'desc')   // secondary sort
                         ->paginate(15)
                         ->appends($request->query());

        return view('periode.index', compact('periode'));
    }

    // ====================== METHOD LAIN (bonus) ======================

    /**
     * Menampilkan form create
     */
    public function create()
    {
        return view('periode.create');
    }

    /**
     * Menyimpan data periode baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'tahun'         => 'required|integer|min:2000|max:2100',
            'bulan'         => 'required|integer|min:1|max:12',
            'tanggal_awal'  => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'status'        => 'required|in:Terbuka,Ditutup,Dikunci',
        ]);

        Periode::create($validated);

        return redirect()->route('periode.index')
                         ->with('success', 'Periode berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail periode
     */
    public function show(Periode $periode)
    {
        $periode->load('perusahaan');
        return view('periode.show', compact('periode'));
    }

    /**
     * Menampilkan form edit
     */
    public function edit(Periode $periode)
    {
        $periode->load('perusahaan');
        return view('periode.edit', compact('periode'));
    }

    /**
     * Update periode
     */
    public function update(Request $request, Periode $periode)
    {
        $validated = $request->validate([
            'tahun'         => 'required|integer|min:2000|max:2100',
            'bulan'         => 'required|integer|min:1|max:12',
            'tanggal_awal'  => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'status'        => 'required|in:Terbuka,Ditutup,Dikunci',
        ]);

        $periode->update($validated);

        return redirect()->route('periode.index')
                         ->with('success', 'Periode berhasil diperbarui.');
    }

    /**
     * Hapus periode
     */
    public function destroy(Periode $periode)
    {
        $periode->delete();

        return redirect()->route('periode.index')
                         ->with('success', 'Periode berhasil dihapus.');
    }
}