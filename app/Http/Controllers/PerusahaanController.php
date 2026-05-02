<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    /**
     * Ambil daftar perusahaan berdasarkan kota (untuk AJAX Chart)
     */
    public function byKota($kota)
    {
        $data = Perusahaan::where('kota', $kota)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($data);
    }

    public function index()
    {
        $data = Perusahaan::latest()->paginate(8);
        return view('perusahaan.index', compact('data'));
    }

    public function create()
    {
        return view('perusahaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:150',
            'npwp' => 'nullable|string|max:30|unique:perusahaan,npwp',
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100|unique:perusahaan,email',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|in:aktif,nonaktif',
        ]);

        $validated['status'] = $validated['status'] ?? 'aktif';

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logo_perusahaan', 'public');
        }

        Perusahaan::create($validated);

        return redirect()->route('perusahaan.index')
            ->with('success', 'Data perusahaan berhasil ditambahkan');
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaan.show', compact('perusahaan'));
    }

    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:150',
            'npwp' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('perusahaan', 'npwp')->ignore($perusahaan->id_perusahaan, 'id_perusahaan'),
            ],
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:30',
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique('perusahaan', 'email')->ignore($perusahaan->id_perusahaan, 'id_perusahaan'),
            ],
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|in:aktif,nonaktif',
        ]);

        $validated['status'] = $validated['status'] ?? $perusahaan->status;

        if ($request->hasFile('logo')) {

            if ($perusahaan->logo && Storage::disk('public')->exists($perusahaan->logo)) {
                Storage::disk('public')->delete($perusahaan->logo);
            }

            $validated['logo'] = $request->file('logo')->store('logo_perusahaan', 'public');
        }

        $perusahaan->update($validated);

        return redirect()->route('perusahaan.index')
            ->with('success', 'Data perusahaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        try {
            if ($perusahaan->logo && Storage::disk('public')->exists($perusahaan->logo)) {
                Storage::disk('public')->delete($perusahaan->logo);
            }

            $perusahaan->delete();

            return redirect()->route('perusahaan.index')
                ->with('success', 'Data perusahaan berhasil dihapus');
        } catch (\Exception $e) {

            return redirect()->route('perusahaan.index')
                ->with('error', 'Gagal menghapus data perusahaan');
        }
    }
}