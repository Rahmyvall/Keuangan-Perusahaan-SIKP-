<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'supplier';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_supplier';

    /**
     * Karena tabel tidak memakai timestamps
     */
    public $timestamps = false;

    /**
     * Mass assignment
     */
    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'alamat',
        'telepon',
        'id_perusahaan',
    ];

    /**
     * Casting data
     */
    protected $casts = [
        'id_supplier'   => 'integer',
        'id_perusahaan' => 'integer',
    ];

    /**
     * Relasi ke tabel perusahaan
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
