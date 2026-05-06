<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';
    public $timestamps = false; // karena pakai created_at manual

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'tipe_akun',
        'sub_tipe',
        'saldo_normal',
        'level',
        'parent_id',
        'id_mata_uang',
        'is_active',
        'created_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // Relasi ke parent akun (self join)
    public function parent()
    {
        return $this->belongsTo(Akun::class, 'parent_id', 'id_akun');
    }

    // Relasi ke anak akun
    public function children()
    {
        return $this->hasMany(Akun::class, 'parent_id', 'id_akun');
    }

    // Relasi ke mata uang
    public function mataUang()
    {
        return $this->belongsTo(MataUang::class, 'id_mata_uang', 'id_mata_uang');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (opsional tapi berguna)
    |--------------------------------------------------------------------------
    */

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTipe($query, $tipe)
    {
        return $query->where('tipe_akun', $tipe);
    }

        // Override latest() - FIX UTAMA
    public function scopeLatest($query)
    {
        return $query->orderBy('id_mata_uang', 'desc');
    }

    public function scopeLatestData($query)
    {
        return $query->orderBy('id_mata_uang', 'desc');
    }
}