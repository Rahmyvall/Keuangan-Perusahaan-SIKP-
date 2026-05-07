<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturPenjualan extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */
    protected $table = 'faktur_penjualan';

    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */
    protected $primaryKey = 'id_faktur_penjualan';

    /*
    |--------------------------------------------------------------------------
    | TIMESTAMP
    |--------------------------------------------------------------------------
    */
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'nomor_faktur',
        'tanggal',
        'id_pelanggan',
        'id_jurnal',
        'subtotal',
        'ppn',
        'total',
        'status',
        'id_perusahaan',
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTING
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'tanggal'  => 'date:Y-m-d',
        'subtotal' => 'decimal:2',
        'ppn'      => 'decimal:2',
        'total'    => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | DEFAULT ATTRIBUTE
    |--------------------------------------------------------------------------
    */
    protected $attributes = [
        'ppn'    => 0,
        'status' => 'Belum Lunas',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(
            Pelanggan::class,
            'id_pelanggan',
            'id_pelanggan'
        );
    }

    /**
     * Relasi ke jurnal
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
     * Relasi ke perusahaan
     */
    public function perusahaan()
    {
        return $this->belongsTo(
            Perusahaan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    /**
     * Format subtotal rupiah
     */
    public function getSubtotalRupiahAttribute()
    {
        return 'Rp ' .
            number_format(
                $this->subtotal,
                2,
                ',',
                '.'
            );
    }

    /**
     * Format ppn rupiah
     */
    public function getPpnRupiahAttribute()
    {
        return 'Rp ' .
            number_format(
                $this->ppn,
                2,
                ',',
                '.'
            );
    }

    /**
     * Format total rupiah
     */
    public function getTotalRupiahAttribute()
    {
        return 'Rp ' .
            number_format(
                $this->total,
                2,
                ',',
                '.'
            );
    }

    /**
     * Format tanggal indonesia
     */
    public function getTanggalFormatAttribute()
    {
        return date(
            'd-m-Y',
            strtotime($this->tanggal)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope lunas
     */
    public function scopeLunas($query)
    {
        return $query->where(
            'status',
            'Lunas'
        );
    }

    /**
     * Scope belum lunas
     */
    public function scopeBelumLunas($query)
    {
        return $query->where(
            'status',
            'Belum Lunas'
        );
    }

    /**
     * Scope dibatalkan
     */
    public function scopeDibatalkan($query)
    {
        return $query->where(
            'status',
            'Dibatalkan'
        );
    }

    /**
     * Scope by perusahaan
     */
    public function scopeByPerusahaan(
        $query,
        $idPerusahaan
    ) {
        return $query->where(
            'id_perusahaan',
            $idPerusahaan
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * Cek status lunas
     */
    public function isLunas()
    {
        return $this->status === 'Lunas';
    }

    /**
     * Cek status belum lunas
     */
    public function isBelumLunas()
    {
        return $this->status === 'Belum Lunas';
    }

    /**
     * Cek status dibatalkan
     */
    public function isDibatalkan()
    {
        return $this->status === 'Dibatalkan';
    }

}