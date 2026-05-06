<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Periode::with('perusahaan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tahun', 'like', "%{$search}%")
                  ->orWhere('bulan', 'like', "%{$search}%")
                  ->orWhereHas('perusahaan', fn($pq) => $pq->where('nama_perusahaan', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('id_perusahaan')) {
            $query->where('id_perusahaan', $request->id_perusahaan);
        }

        $periode = $query->orderBy('tahun', 'desc')
                         ->orderBy('bulan', 'desc')
                         ->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $periode->items(),
            'meta'    => [
                'total'         => $periode->total(),
                'per_page'      => $periode->perPage(),
                'current_page'  => $periode->currentPage(),
                'last_page'     => $periode->lastPage(),
            ]
        ]);
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'tahun'         => 'required|integer|min:2020|max:2035',
            'bulan'         => 'required|integer|min:1|max:12',
            'tanggal_awal'  => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'status'        => 'required|in:Terbuka,Ditutup,Dikunci',
        ]);

        $periode = Periode::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Periode berhasil dibuat',
            'data'    => $periode->load('perusahaan')
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Periode $periode)
    {
        return response()->json([
            'success' => true,
            'data'    => $periode->load('perusahaan')
        ]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Periode $periode)
    {
        $validated = $request->validate([
            'id_perusahaan' => 'sometimes|exists:perusahaan,id_perusahaan',
            'tahun'         => 'sometimes|integer|min:2020|max:2035',
            'bulan'         => 'sometimes|integer|min:1|max:12',
            'tanggal_awal'  => 'sometimes|date',
            'tanggal_akhir' => 'sometimes|date|after_or_equal:tanggal_awal',
            'status'        => 'sometimes|in:Terbuka,Ditutup,Dikunci',
        ]);

        $periode->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Periode berhasil diperbarui',
            'data'    => $periode->fresh()->load('perusahaan')
        ]);
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Periode $periode)
    {
        $periode->delete();

        return response()->json([
            'success' => true,
            'message' => 'Periode berhasil dihapus'
        ], Response::HTTP_NO_CONTENT);
    }

    // Bonus Endpoints
    public function aktif()
    {
        $periode = Periode::with('perusahaan')
                    ->aktif()
                    ->terbaru()
                    ->get();

        return response()->json([
            'success' => true,
            'data'    => $periode
        ]);
    }

    public function byPerusahaan($id_perusahaan)
    {
        $periode = Periode::with('perusahaan')
                    ->where('id_perusahaan', $id_perusahaan)
                    ->orderBy('tahun', 'desc')
                    ->orderBy('bulan', 'desc')
                    ->get();

        return response()->json([
            'success' => true,
            'data'    => $periode
        ]);
    }
}