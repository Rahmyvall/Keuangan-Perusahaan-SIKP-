<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $primaryKey = 'id_supplier';

    public $timestamps = false;

    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'alamat',
        'telepon',
        'email',
        'id_perusahaan',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'id_supplier'   => 'integer',
        'id_perusahaan' => 'integer',
    ];

    // ========================================
    // RELASI
    // ========================================

    public function perusahaan()
    {
        return $this->belongsTo(
            Perusahaan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }

    public function fakturPembelian()
    {
        return $this->hasMany(
            FakturPembelian::class,
            'id_supplier',
            'id_supplier'
        );
    }

    // OPTIONAL (hapus kalau tidak ada kolom relasi)
    public function jurnal()
    {
        return $this->hasMany(
            Jurnal::class,
            'id_supplier',
            'id_supplier'
        );
    }

    // ========================================
    // SCOPE
    // ========================================

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeCari($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_supplier', 'like', "%{$keyword}%")
              ->orWhere('kode_supplier', 'like', "%{$keyword}%");
        });
    }
}
