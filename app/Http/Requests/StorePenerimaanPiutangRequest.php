<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenerimaanPiutangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ubah sesuai logic permission Anda nanti
    }

    public function rules(): array
    {
        return [
            'nomor_penerimaan'    => 'required|string|max:50|unique:penerimaan_piutang,nomor_penerimaan',
            'tanggal'             => 'required|date|before_or_equal:today',
            'id_faktur_penjualan' => 'required|exists:faktur_penjualan,id_faktur_penjualan',
            'id_jurnal'           => 'nullable|exists:jurnal,id_jurnal',
            'jumlah'              => 'required|numeric|min:0.01|max:999999999999.99',
            'id_perusahaan'       => 'required|exists:perusahaan,id_perusahaan',
        ];
    }

    public function messages(): array
    {
        return [
            'nomor_penerimaan.unique' => 'Nomor penerimaan sudah pernah digunakan.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini.',
            'jumlah.min'              => 'Jumlah penerimaan minimal Rp 0,01.',
        ];
    }
}
