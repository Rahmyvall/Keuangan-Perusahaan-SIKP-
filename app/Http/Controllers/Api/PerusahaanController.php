<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    // GET /api/perusahaan
    public function index()
    {
        $data = Perusahaan::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List data perusahaan',
            'data' => $data
        ]);
    }

    // POST /api/perusahaan
    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string',
            'npwp' => 'nullable|string',
            'kota' => 'nullable|string',
            'alamat' => 'nullable|string',
            'status' => 'nullable|in:aktif,nonaktif',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // upload logo
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('perusahaan', 'public');
        }

        $perusahaan = Perusahaan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Perusahaan berhasil ditambahkan',
            'data' => $perusahaan
        ], 201);
    }

    // GET /api/perusahaan/{id}
    public function show($id)
    {
        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $perusahaan
        ]);
    }

    // PUT /api/perusahaan/{id}
    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama_perusahaan' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string',
            'npwp' => 'nullable|string',
            'kota' => 'nullable|string',
            'alamat' => 'nullable|string',
            'status' => 'nullable|in:aktif,nonaktif',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // update logo
        if ($request->hasFile('logo')) {

            // hapus logo lama
            if ($perusahaan->logo && Storage::disk('public')->exists($perusahaan->logo)) {
                Storage::disk('public')->delete($perusahaan->logo);
            }

            $data['logo'] = $request->file('logo')->store('perusahaan', 'public');
        }

        $perusahaan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Perusahaan berhasil diupdate',
            'data' => $perusahaan
        ]);
    }

    // DELETE /api/perusahaan/{id}
    public function destroy($id)
    {
        $perusahaan = Perusahaan::find($id);

        if (!$perusahaan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // hapus logo
        if ($perusahaan->logo && Storage::disk('public')->exists($perusahaan->logo)) {
            Storage::disk('public')->delete($perusahaan->logo);
        }

        $perusahaan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Perusahaan berhasil dihapus'
        ]);
    }
}
