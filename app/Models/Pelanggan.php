<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'pelanggan';

    // Primary Key
    protected $primaryKey = 'id_pelanggan';

    // Tipe primary key
    protected $keyType = 'int';

    // Auto increment
    public $incrementing = true;

    // Penting: Tabel tidak punya kolom created_at & updated_at
    public $timestamps = false;   // ← Baris ini yang diperbaiki

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'kode_pelanggan',
        'nama_pelanggan',
        'alamat',
        'telepon',
        'email',
        'limit_kredit',
        'id_perusahaan',
    ];

    // Casting tipe data
    protected $casts = [
        'limit_kredit'   => 'decimal:2',
        'id_perusahaan'  => 'integer',
    ];

    // Default value
    protected $attributes = [
        'limit_kredit' => 0,
    ];

    /**
     * Relationship ke tabel perusahaan
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
