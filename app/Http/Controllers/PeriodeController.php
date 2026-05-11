<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\Perusahaan;

class PeriodeController extends Controller
{
    /**
     * Display listing data periode
     */
    public function index(Request $request)
    {
        $query = Periode::with('perusahaan');

        // ================= SEARCH =================
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('tahun', 'like', "%{$search}%")
                  ->orWhere('bulan', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")

                  ->orWhereHas('perusahaan', function ($pq) use ($search) {

                      $pq->where(
                          'nama_perusahaan',
                          'like',
                          "%{$search}%"
                      );
                  });
            });
        }

        // ================= FILTER STATUS =================
        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }

        // ================= FILTER PERUSAHAAN =================
        if ($request->filled('id_perusahaan')) {

            $query->where(
                'id_perusahaan',
                $request->id_perusahaan
            );
        }

        // ================= SORTING =================
        $sort = $request->get('sort', 'tahun');

        $direction = $request->get('direction', 'desc');

        $allowedSort = [
            'id_periode',
            'tahun',
            'bulan',
            'tanggal_awal',
            'tanggal_akhir',
            'status',
            'created_at'
        ];

        if (!in_array($sort, $allowedSort)) {
            $sort = 'tahun';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $periode = $query
            ->orderBy($sort, $direction)
            ->orderBy('bulan', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('periode.index', [
            'periode' => $periode
        ]);
    }

    /**
     * Form create
     */
    public function create()
    {
        $perusahaan = Perusahaan::all();

        return view('periode.create', [
            'perusahaan' => $perusahaan
        ]);
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',

            'tahun' => 'required|integer|min:2000|max:2100',

            'bulan' => 'required|integer|min:1|max:12',

            'tanggal_awal' => 'required|date',

            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',

            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        Periode::create($validated);

        return redirect()
            ->route('periode.index')
            ->with(
                'success',
                'Data periode berhasil ditambahkan.'
            );
    }

    /**
     * Detail data
     */
    public function show($id)
    {
        $periode = Periode::with('perusahaan')
            ->findOrFail($id);

        return view('periode.show', [
            'periode' => $periode
        ]);
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $periode = Periode::findOrFail($id);

        $perusahaan = Perusahaan::all();

        return view('periode.edit', [
            'periode' => $periode,
            'perusahaan' => $perusahaan
        ]);
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $periode = Periode::findOrFail($id);

        $validated = $request->validate([

            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',

            'tahun' => 'required|integer|min:2000|max:2100',

            'bulan' => 'required|integer|min:1|max:12',

            'tanggal_awal' => 'required|date',

            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',

            'status' => 'required|in:Aktif,Nonaktif'
        ]);

        $periode->update($validated);

        return redirect()
            ->route('periode.index')
            ->with(
                'success',
                'Data periode berhasil diperbarui.'
            );
    }

    /**
     * Delete data
     */
    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);

        $periode->delete();

        return redirect()
            ->route('periode.index')
            ->with(
                'success',
                'Data periode berhasil dihapus.'
            );
    }
}