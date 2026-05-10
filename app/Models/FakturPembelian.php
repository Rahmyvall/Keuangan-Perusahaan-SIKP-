<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturPembelian extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'faktur_pembelian';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_faktur_pembelian';

    /**
     * Incrementing bigint
     */
    public $incrementing = true;

    protected $keyType = 'int';

    /**
     * Timestamps
     */
    public $timestamps = false;

    /**
     * Mass assignment
     */
    protected $fillable = [
        'nomor_faktur',
        'tanggal',
        'id_supplier',
        'id_jurnal',
        'subtotal',
        'ppn',
        'total',
        'status',
        'id_perusahaan',
    ];

    /**
     * Casting data
     */
    protected $casts = [
        'tanggal'   => 'date',
        'subtotal'  => 'decimal:2',
        'ppn'       => 'decimal:2',
        'total'     => 'decimal:2',
    ];

    // ======================================================
    // RELASI
    // ======================================================

    /**
     * Supplier
     */
    public function supplier()
    {
        return $this->belongsTo(
            Supplier::class,
            'id_supplier',
            'id_supplier'
        );
    }

    /**
     * Jurnal
     */
    public function jurnal()
    {
        return $this->belongsTo(
            Jurnal::class,
            'id_jurnal',
            'id_jurnal'
        );
    }

    /**
     * Perusahaan
     */
    public function perusahaan()
    {
        return $this->belongsTo(
            Perusahaan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }

    // ======================================================
    // QUERY SCOPE
    // ======================================================

    /**
     * Status belum lunas
     */
    public function scopeBelumLunas($query)
    {
        return $query->where('status', 'Belum Lunas');
    }

    /**
     * Status lunas
     */
    public function scopeLunas($query)
    {
        return $query->where('status', 'Lunas');
    }

    /**
     * Status dibatalkan
     */
    public function scopeDibatalkan($query)
    {
        return $query->where('status', 'Dibatalkan');
    }

    /**
     * Filter periode tanggal
     */
    public function scopePeriode($query, $awal, $akhir)
    {
        return $query->whereBetween('tanggal', [$awal, $akhir]);
    }

    /**
     * Pencarian faktur
     */
    public function scopeCari($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {

            $q->where('nomor_faktur', 'like', "%{$keyword}%")

              ->orWhereHas('supplier', function ($supplier) use ($keyword) {
                  $supplier->where(
                      'nama_supplier',
                      'like',
                      "%{$keyword}%"
                  );
              });

        });
    }

    // ======================================================
    // ACCESSOR
    // ======================================================

    /**
     * Format total rupiah
     */
    public function getTotalRupiahAttribute()
    {
        return 'Rp ' . number_format($this->total, 2, ',', '.');
    }

    /**
     * Badge status
     */
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {

            'Lunas' =>
                '<span class="badge bg-success">Lunas</span>',

            'Belum Lunas' =>
                '<span class="badge bg-warning">Belum Lunas</span>',

            'Dibatalkan' =>
                '<span class="badge bg-danger">Dibatalkan</span>',

            default =>
                '<span class="badge bg-secondary">'
                . e($this->status) .
                '</span>',
        };
    }
}