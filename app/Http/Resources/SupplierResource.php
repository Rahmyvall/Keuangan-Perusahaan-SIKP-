<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id_supplier'   => $this->id_supplier,
            'kode_supplier' => $this->kode_supplier,
            'nama_supplier' => $this->nama_supplier,
            'alamat'        => $this->alamat,
            'telepon'       => $this->telepon,

            'perusahaan' => [
                'id_perusahaan'   => $this->perusahaan?->id_perusahaan,
                'nama_perusahaan' => $this->perusahaan?->nama_perusahaan,
            ],

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
