<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PelangganResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id_pelanggan'     => $this->id_pelanggan,
            'kode_pelanggan'   => $this->kode_pelanggan,
            'nama_pelanggan'   => $this->nama_pelanggan,
            'alamat'           => $this->alamat,
            'telepon'          => $this->telepon,
            'email'            => $this->email,
            'limit_kredit'     => (float) $this->limit_kredit,
            'limit_kredit_rp'  => 'Rp ' . number_format($this->limit_kredit, 0, ',', '.'),

            // Relasi Perusahaan
            'perusahaan' => $this->whenLoaded('perusahaan', function () {
                return [
                    'id_perusahaan'   => $this->perusahaan->id_perusahaan,
                    'nama_perusahaan' => $this->perusahaan->nama_perusahaan,
                    // tambahkan field lain jika diperlukan
                ];
            }),

            // Informasi tambahan
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            // URL (opsional)
            'url_detail' => route('api.pelanggan.show', $this->id_pelanggan),
        ];
    }
}
