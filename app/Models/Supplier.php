<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'supplier';

    /**
     * Primary Key
     */
    protected $primaryKey = 'id_supplier';

    /**
     * Tabel tidak menggunakan timestamps
     */
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi (Mass Assignment)
     */
    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'alamat',
        'telepon',
        'email',           // tambahkan jika ada kolom ini
        'id_perusahaan',
        'keterangan',      // tambahkan jika ada
        'status',          // tambahkan jika ada
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'id_supplier'    => 'integer',
        'id_perusahaan'  => 'integer',
        'status'         => 'boolean',     // jika ada kolom status aktif/tidak
    ];

    // ========================================
    // RELASI
    // ========================================

    /**
     * Relasi ke Perusahaan
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    /**
     * Relasi ke Faktur Pembelian
     * Satu Supplier bisa memiliki banyak Faktur Pembelian
     */
    public function fakturPembelian()
    {
        return $this->hasMany(
            FakturPembelian::class, 
            'id_supplier',      // foreign key di tabel faktur_pembelian
            'id_supplier'       // local key di tabel supplier
        );
    }

    /**
     * Relasi ke Jurnal (jika diperlukan)
     */
    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'id_supplier', 'id_supplier');
    }

    // ========================================
    // SCOPE & HELPER
    // ========================================

    /**
     * Scope untuk supplier aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeCari($query, $keyword)
    {
        return $query->where('nama_supplier', 'like', "%{$keyword}%")
                     ->orWhere('kode_supplier', 'like', "%{$keyword}%");
    }
}