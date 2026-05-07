<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PelangganResource;
use App\Models\Pelanggan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Pelanggan::with('perusahaan');

    if ($request->filled('id_perusahaan')) {
        $query->where('id_perusahaan', $request->id_perusahaan);
    }

    if ($request->filled('search')) {
        $search = trim($request->search);
        $query->where(function($q) use ($search) {
            $q->where('kode_pelanggan', 'like', "%{$search}%")
              ->orWhere('nama_pelanggan', 'like', "%{$search}%")
              ->orWhere('telepon', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $pelanggan = $query->orderBy('id_pelanggan', 'desc')
                       ->paginate(15)
                       ->withQueryString();

    return response()->json([
        'success' => true,
        'message' => 'Data pelanggan berhasil diambil',
        'data'    => PelangganResource::collection($pelanggan->items()),
        'meta'    => [
            'current_page' => $pelanggan->currentPage(),
            'last_page'    => $pelanggan->lastPage(),
            'per_page'     => $pelanggan->perPage(),
            'total'        => $pelanggan->total(),
            'from'         => $pelanggan->firstItem(),
            'to'           => $pelanggan->lastItem(),
        ]
    ]);
}

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'required|string|max:150',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:100',
            'limit_kredit'   => 'nullable|numeric|min:0',
            'id_perusahaan'  => 'required|exists:perusahaan,id_perusahaan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Generate Kode Otomatis
        $last = Pelanggan::orderBy('id_pelanggan', 'desc')->first();
        $next = $last ? intval(substr($last->kode_pelanggan, 5)) + 1 : 1;
        $kode = 'CUST-' . str_pad($next, 3, '0', STR_PAD_LEFT);

        $pelanggan = Pelanggan::create([
            'kode_pelanggan' => $kode,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat'         => $request->alamat,
            'telepon'        => $request->telepon,
            'email'          => $request->email,
            'limit_kredit'   => $request->limit_kredit ?? 0,
            'id_perusahaan'  => $request->id_perusahaan,
        ]);

        $pelanggan->load('perusahaan');

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil ditambahkan',
            'data'    => $pelanggan
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load('perusahaan');

        return response()->json([
            'success' => true,
            'data'    => new PelangganResource($pelanggan)
        ]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validator = Validator::make($request->all(), [
            'kode_pelanggan' => 'required|string|max:20|unique:pelanggan,kode_pelanggan,' . $pelanggan->id_pelanggan . ',id_pelanggan',
            'nama_pelanggan' => 'required|string|max:150',
            'alamat'         => 'nullable|string',
            'telepon'        => 'nullable|string|max:30',
            'email'          => 'nullable|email|max:100',
            'limit_kredit'   => 'nullable|numeric|min:0',
            'id_perusahaan'  => 'required|exists:perusahaan,id_perusahaan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $pelanggan->update($request->all());
        $pelanggan->load('perusahaan');

        return response()->json([
            'success' => true,
            'message' => 'Data pelanggan berhasil diperbarui',
            'data'    => $pelanggan
        ]);
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil dihapus'
        ]);
    }
}
