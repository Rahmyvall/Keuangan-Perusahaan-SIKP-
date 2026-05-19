<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaldoAwal;
use App\Http\Resources\SaldoAwalResource;

class SaldoAwalController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $data = SaldoAwal::with(['akun','periode'])
            ->latest()
            ->paginate(10);

        return SaldoAwalResource::collection($data);
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'id_akun' => 'required|exists:akun,id_akun',
            'id_periode' => 'required|exists:periode,id_periode',
            'debit' => 'nullable|numeric',
            'kredit' => 'nullable|numeric',
        ]);

        // CEK DUPLIKAT
        $exists = SaldoAwal::where('id_akun', $request->id_akun)
            ->where('id_periode', $request->id_periode)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Saldo awal sudah ada untuk akun & periode ini'
            ], 422);
        }

        $data = SaldoAwal::create([
            'id_akun' => $request->id_akun,
            'id_periode' => $request->id_periode,
            'debit' => $request->debit ?? 0,
            'kredit' => $request->kredit ?? 0,
        ]);

        return new SaldoAwalResource($data);
    }

    // ================= SHOW =================
    public function show($id)
    {
        $data = SaldoAwal::with(['akun','periode'])->findOrFail($id);

        return new SaldoAwalResource($data);
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'debit' => 'nullable|numeric',
            'kredit' => 'nullable|numeric',
        ]);

        $data = SaldoAwal::findOrFail($id);

        $data->update([
            'debit' => $request->debit ?? $data->debit,
            'kredit' => $request->kredit ?? $data->kredit,
        ]);

        return new SaldoAwalResource($data);
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $data = SaldoAwal::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
