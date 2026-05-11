<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Periode extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'periode';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_periode';

    /**
     * Primary key auto increment
     */
    public $incrementing = true;

    /**
     * Tipe primary key
     */
    protected $keyType = 'int';

    /**
     * Jika tabel tidak memiliki
     * created_at & updated_at
     */
    public $timestamps = false;

    /**
     * Mass assignment
     */
    protected $fillable = [
        'id_perusahaan',
        'tahun',
        'bulan',
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    /**
     * Casting data
     */
    protected $casts = [
        'id_perusahaan' => 'integer',
        'tahun'         => 'integer',
        'bulan'         => 'integer',
        'tanggal_awal'  => 'date',
        'tanggal_akhir' => 'date',
        'status'        => 'string',
    ];

    /**
     * Default value
     */
    protected $attributes = [
        'status' => 'Terbuka',
    ];

    // ==================================================
    // RELATIONSHIP
    // ==================================================

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(
            Perusahaan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }

    // ==================================================
    // SCOPES
    // ==================================================

    /**
     * Scope status aktif / terbuka
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Terbuka');
    }

    /**
     * Scope filter perusahaan
     */
    public function scopePerusahaan($query, $id_perusahaan)
    {
        return $query->where(
            'id_perusahaan',
            $id_perusahaan
        );
    }

    /**
     * Scope periode saat ini
     */
    public function scopeSaatIni($query, $tanggal = null)
    {
        $tanggal = $tanggal ?? now();

        return $query
            ->whereDate('tanggal_awal', '<=', $tanggal)
            ->whereDate('tanggal_akhir', '>=', $tanggal);
    }

    /**
     * Scope data terbaru
     */
    public function scopeTerbaru($query)
    {
        return $query
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc');
    }

    // ==================================================
    // ACCESSOR
    // ==================================================

    /**
     * Nama bulan Indonesia
     */
    public function getNamaBulanAttribute(): string
    {
        $bulan = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $bulan[$this->bulan] ?? '-';
    }

    /**
     * Label periode
     */
    public function getLabelAttribute(): string
    {
        return $this->nama_bulan . ' ' . $this->tahun;
    }

    /**
     * Badge status
     */
    public function getStatusBadgeAttribute(): string
    {
        if ($this->status == 'Terbuka') {

            return '<span class="badge bg-success">Terbuka</span>';

        } elseif ($this->status == 'Ditutup') {

            return '<span class="badge bg-danger">Ditutup</span>';

        } elseif ($this->status == 'Dikunci') {

            return '<span class="badge bg-warning text-dark">Dikunci</span>';

        }

        return '<span class="badge bg-secondary">'
                . e($this->status) .
               '</span>';
    }

    // ==================================================
    // HELPER
    // ==================================================

    /**
     * Menghitung durasi hari
     */
    public function getDurasiHariAttribute(): int
    {
        return $this->tanggal_awal
            ->diffInDays($this->tanggal_akhir) + 1;
    }
}