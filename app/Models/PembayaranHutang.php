<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranHutang extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'pembayaran_hutang';

    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id_pembayaran';

    /*
    |--------------------------------------------------------------------------
    | AUTO INCREMENT
    |--------------------------------------------------------------------------
    */

    public $incrementing = true;

    /*
    |--------------------------------------------------------------------------
    | KEY TYPE
    |--------------------------------------------------------------------------
    */

    protected $keyType = 'int';

    /*
    |--------------------------------------------------------------------------
    | TIMESTAMPS
    |--------------------------------------------------------------------------
    */

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'nomor_pembayaran',
        'tanggal',
        'id_faktur_pembelian',
        'id_jurnal',
        'jumlah',
        'id_perusahaan',
    ];

    /*
    |--------------------------------------------------------------------------
    | HIDDEN
    |--------------------------------------------------------------------------
    */

    protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'id_pembayaran'        => 'integer',
        'tanggal'              => 'date:Y-m-d',
        'id_faktur_pembelian'  => 'integer',
        'id_jurnal'            => 'integer',
        'jumlah'               => 'decimal:2',
        'id_perusahaan'        => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION : FAKTUR PEMBELIAN
    |--------------------------------------------------------------------------
    */

    public function fakturPembelian()
    {
        return $this->belongsTo(
            FakturPembelian::class,
            'id_faktur_pembelian',
            'id_faktur_pembelian'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION : JURNAL
    |--------------------------------------------------------------------------
    */

    public function jurnal()
    {
        return $this->belongsTo(
            Jurnal::class,
            'id_jurnal',
            'id_jurnal'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION : PERUSAHAAN
    |--------------------------------------------------------------------------
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

    public function getJumlahFormatAttribute()
    {
        return number_format($this->jumlah, 2, ',', '.');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE
    |--------------------------------------------------------------------------
    */

    public function scopeByPerusahaan($query, $idPerusahaan)
    {
        return $query->where('id_perusahaan', $idPerusahaan);
    }

    public function scopeByTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }
}