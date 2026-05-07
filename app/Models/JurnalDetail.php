<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurnalDetail extends Model
{
    use HasFactory;

    protected $table = 'jurnal_detail';
    protected $primaryKey = 'id_detail';

    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = true;

    /**
     * Kolom yang boleh diisi massal
     */
    protected $fillable = [
        'id_jurnal',
        'id_akun',
        'debit',
        'kredit',
        'keterangan',
        'id_mata_uang',
        'kurs',
        'created_by',
        'updated_by',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'debit'         => 'decimal:2',
        'kredit'        => 'decimal:2',
        'kurs'          => 'decimal:4',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /**
     * RELATIONSHIPS
     */

    // Detail belongs to Jurnal (Header)
    public function jurnal(): BelongsTo
    {
        return $this->belongsTo(Jurnal::class, 'id_jurnal', 'id_jurnal');
    }

    // Detail belongs to Akun (Chart of Account)
    public function akun(): BelongsTo
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    // Detail belongs to Mata Uang
    public function mataUang(): BelongsTo
    {
        return $this->belongsTo(MataUang::class, 'id_mata_uang', 'id_mata_uang');
    }

    /**
     * ACCESSORS & MUTATORS
     */

    // Total dalam rupiah (jika multi-currency)
    public function getNilaiRupiahAttribute(): float
    {
        return ($this->debit - $this->kredit) * $this->kurs;
    }

    // Tipe posting (Debit / Kredit)
    public function getTipeAttribute(): string
    {
        if ($this->debit > 0) return 'DEBIT';
        if ($this->kredit > 0) return 'KREDIT';
        return 'NETRAL';
    }

    /**
     * SCOPE
     */
    public function scopeDebit($query)
    {
        return $query->where('debit', '>', 0);
    }

    public function scopeKredit($query)
    {
        return $query->where('kredit', '>', 0);
    }

    /**
     * METHOD BERGUNA
     */
    public function isBalancedRow(): bool
    {
        return ($this->debit > 0 && $this->kredit === 0.00) ||
               ($this->kredit > 0 && $this->debit === 0.00);
    }

    // FIX: Pastikan kedua relation ini ada
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'created_by', 'id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'updated_by', 'id');
    }
}
