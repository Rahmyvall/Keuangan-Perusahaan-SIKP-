<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    /**
     * 🔹 LIST semua akun
     */
    public function index()
    {
        $akun = Akun::with(['parent', 'children', 'mataUang'])
            ->orderBy('kode_akun', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data akun berhasil diambil',
            'data' => $akun
        ]);
    }

    /**
     * 🔹 DETAIL akun
     */
    public function show($id)
    {
        $akun = Akun::with(['parent', 'children', 'mataUang'])
            ->find($id);

        if (!$akun) {
            return response()->json([
                'status' => false,
                'message' => 'Akun tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail akun',
            'data' => $akun
        ]);
    }

    /**
     * 🔹 CREATE akun baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_akun' => 'required|string|max:20|unique:akun,kode_akun',
            'nama_akun' => 'required|string|max:150',
            'tipe_akun' => ['required', Rule::in(['Aset','Liabilitas','Ekuitas','Pendapatan','Beban'])],
            'sub_tipe' => 'nullable|string|max:50',
            'saldo_normal' => ['required', Rule::in(['Debit','Kredit'])],
            'level' => 'required|integer|min:1',
            'parent_id' => 'nullable|exists:akun,id_akun',
            'id_mata_uang' => 'required|exists:mata_uang,id_mata_uang',
            'is_active' => 'boolean'
        ]);

        $akun = Akun::create([
            'kode_akun' => $request->kode_akun,
            'nama_akun' => $request->nama_akun,
            'tipe_akun' => $request->tipe_akun,
            'sub_tipe' => $request->sub_tipe,
            'saldo_normal' => $request->saldo_normal,
            'level' => $request->level,
            'parent_id' => $request->parent_id,
            'id_mata_uang' => $request->id_mata_uang,
            'is_active' => $request->is_active ?? true,
            'created_at' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Akun berhasil dibuat',
            'data' => $akun
        ], 201);
    }

    /**
     * 🔹 UPDATE akun
     */
    public function update(Request $request, $id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return response()->json([
                'status' => false,
                'message' => 'Akun tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'kode_akun' => [
                'sometimes',
                'string',
                'max:20',
                Rule::unique('akun', 'kode_akun')->ignore($id, 'id_akun')
            ],
            'nama_akun' => 'sometimes|string|max:150',
            'tipe_akun' => ['sometimes', Rule::in(['Aset','Liabilitas','Ekuitas','Pendapatan','Beban'])],
            'sub_tipe' => 'nullable|string|max:50',
            'saldo_normal' => ['sometimes', Rule::in(['Debit','Kredit'])],
            'level' => 'sometimes|integer|min:1',
            'parent_id' => 'nullable|exists:akun,id_akun',
            'id_mata_uang' => 'sometimes|exists:mata_uang,id_mata_uang',
            'is_active' => 'boolean'
        ]);

        $akun->update($request->only([
            'kode_akun',
            'nama_akun',
            'tipe_akun',
            'sub_tipe',
            'saldo_normal',
            'level',
            'parent_id',
            'id_mata_uang',
            'is_active'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Akun berhasil diupdate',
            'data' => $akun
        ]);
    }

    /**
     * 🔹 DELETE akun
     */
    public function destroy($id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return response()->json([
                'status' => false,
                'message' => 'Akun tidak ditemukan'
            ], 404);
        }

        $akun->delete();

        return response()->json([
            'status' => true,
            'message' => 'Akun berhasil dihapus'
        ]);
    }
}