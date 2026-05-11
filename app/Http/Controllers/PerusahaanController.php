<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    public function byKota($kota)
    {
        return response()->json(
            Perusahaan::where('kota', $kota)
                ->orderByDesc('id_perusahaan')
                ->get()
        );
    }

    public function index()
    {
        $data = Perusahaan::orderByDesc('id_perusahaan')
            ->paginate(10);

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
            $validated['logo'] = $request->file('logo')
                ->store('logo_perusahaan', 'public');
        }

        Perusahaan::create($validated);

        return redirect()
            ->route('perusahaan.index')
            ->with('success', 'Data perusahaan berhasil ditambahkan');
    }

    public function edit(Perusahaan $perusahaan)
    {
        return view('perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, Perusahaan $perusahaan)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:150',
            'npwp' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('perusahaan', 'npwp')->ignore($perusahaan->getKey()),
            ],
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:30',
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique('perusahaan', 'email')->ignore($perusahaan->getKey()),
            ],
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|in:aktif,nonaktif',
        ]);

        if ($request->hasFile('logo')) {
            if ($perusahaan->logo) {
                Storage::disk('public')->delete($perusahaan->logo);
            }

            $validated['logo'] = $request->file('logo')
                ->store('logo_perusahaan', 'public');
        }

        $perusahaan->update($validated);

        return redirect()
            ->route('perusahaan.index')
            ->with('success', 'Data perusahaan berhasil diperbarui');
    }

    public function destroy(Perusahaan $perusahaan)
    {
        if ($perusahaan->logo) {
            Storage::disk('public')->delete($perusahaan->logo);
        }

        $perusahaan->delete();

        return redirect()
            ->route('perusahaan.index')
            ->with('success', 'Data perusahaan berhasil dihapus');
    }
}
