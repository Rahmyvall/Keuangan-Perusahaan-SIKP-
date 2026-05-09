<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenerimaanPiutangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('penerimaan_piutang'); // sesuai nama route parameter

        return [
            'nomor_penerimaan'    => 'required|string|max:50|unique:penerimaan_piutang,nomor_penerimaan,' . $id . ',id_penerimaan',
            'tanggal'             => 'required|date|before_or_equal:today',
            'id_faktur_penjualan' => 'required|exists:faktur_penjualan,id_faktur_penjualan',
            'id_jurnal'           => 'nullable|exists:jurnal,id_jurnal',
            'jumlah'              => 'required|numeric|min:0.01|max:999999999999.99',
            'id_perusahaan'       => 'required|exists:perusahaan,id_perusahaan',
        ];
    }
}
