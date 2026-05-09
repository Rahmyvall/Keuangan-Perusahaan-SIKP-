<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenerimaanPiutang extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_piutang';
    protected $primaryKey = 'id_penerimaan';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;           // ubah ke true jika sudah ada kolom timestamps

    protected $fillable = [
        'nomor_penerimaan',
        'tanggal',
        'id_faktur_penjualan',
        'id_jurnal',
        'jumlah',
        'id_perusahaan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    /**
     * ROUTE MODEL BINDING - WAJIB!
     */
    public function getRouteKeyName()
    {
        return 'id_penerimaan';
    }

    // ========================================
    // RELATIONSHIPS
    // ========================================
    public function fakturPenjualan(): BelongsTo
    {
        return $this->belongsTo(FakturPenjualan::class, 'id_faktur_penjualan', 'id_faktur_penjualan');
    }

    public function jurnal(): BelongsTo
    {
        return $this->belongsTo(Jurnal::class, 'id_jurnal', 'id_jurnal');
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    // ========================================
    // SCOPES
    // ========================================
    public function scopeTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    public function scopePerusahaan($query, $idPerusahaan)
    {
        return $query->where('id_perusahaan', $idPerusahaan);
    }

    public function scopeNomor($query, $nomor)
    {
        return $query->where('nomor_penerimaan', $nomor);
    }


}