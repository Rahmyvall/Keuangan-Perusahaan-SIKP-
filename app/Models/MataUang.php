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

    // karena tidak ada created_at & updated_at
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
    // ACCESSOR
    // =========================

    // label: "USD - US Dollar"
    public function getLabelAttribute()
    {
        return "{$this->kode} - {$this->nama}";
    }

    // simbol default jika kosong
    public function getSimbolAttribute($value)
    {
        return $value ?: '-';
    }

    // =========================
    // QUERY SCOPE
    // =========================

    // scope by kode
    public function scopeKode($query, $kode)
    {
        return $query->where('kode', strtoupper($kode));
    }

    // scope search (dipakai di controller)
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%")
                ->orWhere('simbol', 'like', "%{$search}%");
        });
    }

    // scope latest (FIX tanpa created_at)
    public function scopeLatestData($query)
    {
        return $query->orderBy('id_mata_uang', 'desc');
    }

    public function akun()
    {
        return $this->hasMany(Akun::class, 'id_mata_uang', 'id_mata_uang');
    }
}
