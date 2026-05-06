<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Periode extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika mengikuti konvensi Laravel)
    protected $table = 'periode';

    // Primary Key
    protected $primaryKey = 'id_periode';

    // Tipe primary key
    protected $keyType = 'int';

    // Auto increment
    public $incrementing = true;

    // Timestamps (sudah ada di migration)
    public $timestamps = true;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'id_perusahaan',
        'tahun',
        'bulan',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    // Casting tipe data
    protected $casts = [
        'tahun'         => 'integer',
        'bulan'         => 'integer',
        'tanggal_awal'  => 'date',
        'tanggal_akhir' => 'date',
        'status'        => 'string',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    // Default values
    protected $attributes = [
        'status' => 'Terbuka',
    ];

    // =====================================
    // RELATIONSHIPS
    // =====================================

    /**
     * Relasi ke Perusahaan
     */
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    // =====================================
    // SCOPE QUERY
    // =====================================

    /**
     * Scope untuk periode yang sedang aktif (Terbuka)
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Terbuka');
    }

    /**
     * Scope untuk perusahaan tertentu
     */
    public function scopePerusahaan($query, $id_perusahaan)
    {
        return $query->where('id_perusahaan', $id_perusahaan);
    }

    /**
     * Scope untuk periode saat ini berdasarkan tanggal
     */
    public function scopeSaatIni($query, $tanggal = null)
    {
        $tanggal = $tanggal ?? now();

        return $query->where('tanggal_awal', '<=', $tanggal)
                     ->where('tanggal_akhir', '>=', $tanggal);
    }

    /**
     * Scope urutkan terbaru
     */
    public function scopeTerbaru($query)
    {
        return $query->orderBy('tahun', 'desc')
                     ->orderBy('bulan', 'desc');
    }

    // =====================================
    // ACCESSORS & MUTATORS
    // =====================================

    /**
     * Nama Bulan (contoh: Januari, Februari, dst)
     */
    public function getNamaBulanAttribute(): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return $bulan[$this->bulan] ?? '';
    }

    /**
     * Label Periode (contoh: Januari 2026)
     */
    public function getLabelAttribute(): string
    {
        return "{$this->nama_bulan} {$this->tahun}";
    }

    /**
     * Status Badge untuk tampilan
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'Terbuka' => '<span class="badge bg-success">Terbuka</span>',
            'Ditutup' => '<span class="badge bg-danger">Ditutup</span>',
            'Dikunci' => '<span class="badge bg-warning">Dikunci</span>',
            default   => '<span class="badge bg-secondary">' . $this->status . '</span>',
        };
    }


}
