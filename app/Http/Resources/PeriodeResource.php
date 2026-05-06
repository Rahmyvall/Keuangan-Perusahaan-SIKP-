<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeriodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_periode'     => $this->id_periode,
            'id_perusahaan'  => $this->id_perusahaan,
            
            // Informasi Periode
            'tahun'          => $this->tahun,
            'bulan'          => $this->bulan,
            'nama_bulan'     => $this->nama_bulan,
            'label'          => $this->label,
            
            // Tanggal
            'tanggal_awal'   => $this->tanggal_awal?->format('Y-m-d'),
            'tanggal_akhir'  => $this->tanggal_akhir?->format('Y-m-d'),
            'tanggal_awal_full' => $this->tanggal_awal?->format('d F Y'),
            'tanggal_akhir_full'=> $this->tanggal_akhir?->format('d F Y'),
            
            // Status
            'status'         => $this->status,
            'status_badge'   => $this->status_badge,     // HTML badge (untuk tampilan)
            'status_color'   => $this->getStatusColor(), // warna untuk frontend
            
            // Relasi
            'perusahaan'     => $this->whenLoaded('perusahaan', function () {
                return [
                    'id_perusahaan'   => $this->perusahaan->id_perusahaan,
                    'nama_perusahaan' => $this->perusahaan->nama_perusahaan,
                    // tambahkan field lain jika diperlukan
                ];
            }),

            // Timestamp
            'created_at'     => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'     => $this->updated_at?->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at?->diffForHumans(),
            'updated_at_human' => $this->updated_at?->diffForHumans(),
        ];
    }

    /**
     * Return color code for status (untuk frontend)
     */
    private function getStatusColor(): string
    {
        return match($this->status) {
            'Terbuka' => 'success',
            'Ditutup' => 'danger',
            'Dikunci' => 'warning',
            default   => 'secondary',
        };
    }
}