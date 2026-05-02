<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;

class PenggunaController extends Controller
{
    // Menampilkan semua data pengguna
    public function index()
    {
        $pengguna = Pengguna::all();

        return view('pengguna.index', compact('pengguna'));
    }
}
