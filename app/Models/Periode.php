<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode';
    protected $primaryKey = 'id_periode';
    protected $keyType = 'int';
    public $incrementing = true;

    /**
     * ❗ PENTING:
     * Ubah ini sesuai kondisi tabel kamu
     * - false → kalau kolom created_at & updated_at TIDAK ADA
     * - true  → kalau kolom ADA
     */
    public $timestamps = false; // ⬅️ FIX ERROR

    protected $fillable = [
        'id_perusahaan',
        'tahun',
        'bulan',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    protected $casts = [
        'tahun'         => 'integer',
        'bulan'         => 'integer',
        'tanggal_awal'  => 'date',
        'tanggal_akhir' => 'date',
        'status'        => 'string',
    ];

    protected $attributes = [
        'status' => 'Terbuka',
    ];

    // =====================================
    // RELATIONSHIPS
    // =====================================

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    // =====================================
    // SCOPES
    // =====================================

    public function scopeAktif($query)
    {
        return $query->where('status', 'Terbuka');
    }

    public function scopePerusahaan($query, $id_perusahaan)
    {
        return $query->where('id_perusahaan', $id_perusahaan);
    }

    public function scopeSaatIni($query, $tanggal = null)
    {
        $tanggal = $tanggal ?? now();

        return $query->whereDate('tanggal_awal', '<=', $tanggal)
                     ->whereDate('tanggal_akhir', '>=', $tanggal);
    }

    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('tahun')
                     ->orderByDesc('bulan');
    }

    // =====================================
    // ACCESSORS
    // =====================================

    public function getNamaBulanAttribute(): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return $bulan[$this->bulan] ?? '';
    }

    public function getLabelAttribute(): string
    {
        return "{$this->nama_bulan} {$this->tahun}";
    }

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