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
        // Hitung Sisa Kredit (Limit Kredit - Total Piutang)
        $totalPiutang = $this->whenLoaded('transaksi')
            ? $this->transaksi->where('status', '!=', 'lunas')->sum('sisa')
            : 0;

        $sisaKredit = max(0, $this->limit_kredit - $totalPiutang);

        return [
            'id_pelanggan'      => $this->id_pelanggan,
            'kode_pelanggan'    => $this->kode_pelanggan,
            'nama_pelanggan'    => $this->nama_pelanggan,
            'alamat'            => $this->alamat,
            'telepon'           => $this->telepon,
            'email'             => $this->email,

            // Kredit Information
            'limit_kredit'      => (float) $this->limit_kredit,
            'limit_kredit_rp'   => 'Rp ' . number_format($this->limit_kredit, 0, ',', '.'),
            'sisa_kredit'       => (float) $sisaKredit,
            'sisa_kredit_rp'    => 'Rp ' . number_format($sisaKredit, 0, ',', '.'),
            'total_piutang'     => (float) $totalPiutang,
            'total_piutang_rp'  => 'Rp ' . number_format($totalPiutang, 0, ',', '.'),

            // Status Kredit
            'status_kredit'     => $this->getStatusKredit($sisaKredit),

            // Relasi Perusahaan
            'perusahaan' => $this->whenLoaded('perusahaan', function () {
                return [
                    'id_perusahaan'   => $this->perusahaan->id_perusahaan,
                    'nama_perusahaan' => $this->perusahaan->nama_perusahaan,
                ];
            }),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Helper untuk status kredit
     */
    private function getStatusKredit($sisaKredit)
    {
        if ($sisaKredit <= 0) {
            return 'HABIS';
        } elseif ($sisaKredit < ($this->limit_kredit * 0.2)) {
            return 'HAMPIR_HABIS';
        } else {
            return 'AMAN';
        }
    }
}
