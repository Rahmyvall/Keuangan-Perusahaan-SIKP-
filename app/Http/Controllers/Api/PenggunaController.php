<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;

class PenggunaController extends Controller
{
    // 🔹 HANYA LIST DATA
    public function index()
    {
        $data = Pengguna::with('perusahaan')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data pengguna berhasil diambil',
            'data' => $data
        ]);
    }
}
