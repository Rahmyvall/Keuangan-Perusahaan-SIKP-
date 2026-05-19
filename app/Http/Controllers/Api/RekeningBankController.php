<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RekeningBank;
use Illuminate\Http\Request;

class RekeningBankController extends Controller
{
    // GET ALL
    public function index()
    {
        return response()->json(
            RekeningBank::with(['akunKas', 'perusahaan'])->get()
        );
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50|unique:rekening_bank,nomor_rekening',
            'nama_rekening' => 'required|string|max:100',
            'id_akun_kas' => 'required|exists:akun,id_akun',
            'saldo_awal' => 'nullable|numeric',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        ]);

        $rekening = RekeningBank::create($request->all());

        return response()->json([
            'message' => 'Rekening bank berhasil dibuat',
            'data' => $rekening
        ], 201);
    }

    // SHOW
    public function show($id)
    {
        $data = RekeningBank::with(['akunKas', 'perusahaan'])
            ->findOrFail($id);

        return response()->json($data);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $rekening = RekeningBank::findOrFail($id);

        $request->validate([
            'nama_bank' => 'sometimes|string|max:100',
            'nomor_rekening' => 'sometimes|string|max:50|unique:rekening_bank,nomor_rekening,' . $id . ',id_rekening',
            'nama_rekening' => 'sometimes|string|max:100',
            'id_akun_kas' => 'sometimes|exists:akun,id_akun',
            'saldo_awal' => 'sometimes|numeric',
            'id_perusahaan' => 'sometimes|exists:perusahaan,id_perusahaan',
        ]);

        $rekening->update($request->all());

        return response()->json([
            'message' => 'Rekening bank berhasil diupdate',
            'data' => $rekening
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $rekening = RekeningBank::findOrFail($id);
        $rekening->delete();

        return response()->json([
            'message' => 'Rekening bank berhasil dihapus'
        ]);
    }
}
