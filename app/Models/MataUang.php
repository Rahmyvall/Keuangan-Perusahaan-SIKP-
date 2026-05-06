<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataUang extends Model
{
    use HasFactory;

    // =========================
    // CONFIG DASAR
    // =========================
    protected $table = 'mata_uang';
    protected $primaryKey = 'id_mata_uang';

    // Tidak pakai timestamps
    public $timestamps = false;

    // =========================
    // MASS ASSIGNMENT
    // =========================
    protected $fillable = [
        'kode',
        'nama',
        'simbol',
    ];

    // =========================
    // CAST
    // =========================
    protected $casts = [
        'id_mata_uang' => 'integer',
    ];

    // =========================
    // DEFAULT ATTRIBUTE
    // =========================
    protected $attributes = [
        'simbol' => null,
    ];

    // =========================
    // ACCESSOR & MUTATOR
    // =========================

    /**
     * Label untuk dropdown/select: "USD - US Dollar"
     */
    public function getLabelAttribute(): string
    {
        return "{$this->kode} - {$this->nama}";
    }

    /**
     * Simbol default jika kosong
     */
    public function getSimbolAttribute($value): string
    {
        return $value ?: '-';
    }

    // =========================
    // QUERY SCOPE
    // =========================

    // =========================
// QUERY SCOPE
// =========================

public function scopeKode($query, $kode)
{
    return $query->where('kode', strtoupper($kode));
}

public function scopeSearch($query, $search)
{
    if (empty($search)) return $query;

    return $query->where(function ($q) use ($search) {
        $q->where('kode', 'like', "%{$search}%")
          ->orWhere('nama', 'like', "%{$search}%")
          ->orWhere('simbol', 'like', "%{$search}%");
    });
}

// FIX untuk latest()
public function scopeLatest($query)
{
    return $query->orderBy('id_mata_uang', 'desc');
}

public function scopeLatestData($query)
{
    return $query->orderBy('id_mata_uang', 'desc');
}
    // =========================
    // RELATIONSHIP
    // =========================
    public function akun()
    {
        return $this->hasMany(Akun::class, 'id_mata_uang', 'id_mata_uang');
    }
}
