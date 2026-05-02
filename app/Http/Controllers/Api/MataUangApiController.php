<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MataUang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataUangApiController extends Controller
{
    /**
     * GET /api/mata-uang
     */
    public function index(Request $request)
    {
        $query = MataUang::query();

        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('simbol', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy('kode')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'List data mata uang',
            'data' => $data
        ]);
    }

    /**
     * POST /api/mata-uang
     */
    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $mataUang = MataUang::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $mataUang
        ], 201);
    }

    /**
     * GET /api/mata-uang/{id}
     */
    public function show($id)
    {
        $mataUang = MataUang::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail mata uang',
            'data' => $mataUang
        ]);
    }

    /**
     * PUT /api/mata-uang/{id}
     */
    public function update(Request $request, $id)
    {
        $mataUang = MataUang::findOrFail($id);

        $validated = $this->validateData($request, $mataUang->id_mata_uang);

        $mataUang->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $mataUang
        ]);
    }

    /**
     * DELETE /api/mata-uang/{id}
     */
    public function destroy($id)
    {
        $mataUang = MataUang::findOrFail($id);

        $mataUang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    /**
     * 🔥 VALIDATION
     */
    private function validateData(Request $request, $id = null)
    {
        return $request->validate([
            'kode' => [
                'required',
                'string',
                'max:3',
                Rule::unique('mata_uang', 'kode')->ignore($id, 'id_mata_uang'),
            ],
            'nama' => 'required|string|max:50',
            'simbol' => 'nullable|string|max:10',
        ]);
    }
}
