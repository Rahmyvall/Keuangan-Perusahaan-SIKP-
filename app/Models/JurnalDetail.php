<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurnalDetail extends Model
{
    use HasFactory;

    // ========================================
    // TABLE CONFIGURATION
    // ========================================
    protected $table = 'jurnal_detail';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;           // karena pakai bigint auto-increment
    protected $keyType = 'int';            // bigint di MySQL/Laravel di-cast sebagai string di PHP, tapi int lebih aman

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'id_jurnal',
        'id_akun',
        'debit',
        'kredit',
        'keterangan',
        'id_mata_uang',
        'kurs',
    ];

    // Casting tipe data
    protected $casts = [
        'id_detail'     => 'integer',
        'id_jurnal'     => 'integer',
        'id_akun'       => 'integer',
        'debit'         => 'decimal:2',
        'kredit'        => 'decimal:2',
        'id_mata_uang'  => 'integer',
        'kurs'          => 'decimal:4',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================

    /**
     * Relasi ke Jurnal (header)
     */
    public function jurnal(): BelongsTo
    {
        return $this->belongsTo(Jurnal::class, 'id_jurnal', 'id_jurnal');
    }

    /**
     * Relasi ke Akun / Chart of Account
     */
    public function akun(): BelongsTo
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    /**
     * Relasi ke Mata Uang
     */
    public function mataUang(): BelongsTo
    {
        return $this->belongsTo(MataUang::class, 'id_mata_uang', 'id_mata_uang');
    }

    // ========================================
    // HELPER / ACCESSORS (Opsional tapi sangat berguna)
    // ========================================

    /**
     * Saldo bersih (debit - kredit)
     */
    public function getSaldoAttribute(): float
    {
        return $this->debit - $this->kredit;
    }

    /**
     * Cek apakah baris ini debit
     */
    public function isDebit(): bool
    {
        return $this->debit > 0;
    }

    /**
     * Cek apakah baris ini kredit
     */
    public function isKredit(): bool
    {
        return $this->kredit > 0;
    }

    // ========================================
    // QUERY SCOPES
    // ========================================

    public function scopeOfJurnal($query, $idJurnal)
    {
        return $query->where('id_jurnal', $idJurnal);
    }

    public function scopeDebitOnly($query)
    {
        return $query->where('debit', '>', 0);
    }

    public function scopeKreditOnly($query)
    {
        return $query->where('kredit', '>', 0);
    }
}
