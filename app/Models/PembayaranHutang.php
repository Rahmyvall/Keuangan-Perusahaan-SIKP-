<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranHutang extends Model
{
    protected $table = 'pembayaran_hutang';

    protected $primaryKey = 'id_pembayaran';

    public $timestamps = false;

    protected $fillable = [
        'nomor_pembayaran',
        'tanggal',
        'id_faktur_pembelian',
        'id_jurnal',
        'jumlah',
        'id_perusahaan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function fakturPembelian()
    {
        return $this->belongsTo(
            FakturPembelian::class,
            'id_faktur_pembelian',
            'id_faktur_pembelian'
        );
    }

    public function jurnal()
    {
        return $this->belongsTo(
            Jurnal::class,
            'id_jurnal',
            'id_jurnal'
        );
    }

    public function perusahaan()
    {
        return $this->belongsTo(
            Perusahaan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }
}