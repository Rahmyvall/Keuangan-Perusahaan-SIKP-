<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::with('perusahaan'); // eager loading untuk menghindari N+1

        // Search (opsional, tapi sangat direkomendasikan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'id_pengguna');
        $direction = $request->get('direction', 'desc');

        $pengguna = $query->orderBy($sort, $direction)
                          ->paginate(15) // 15 data per halaman
                          ->appends($request->query()); // mempertahankan query string di pagination

        return view('pengguna.index', compact('pengguna'));
    }
}