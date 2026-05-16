<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $table = 'akun';

    protected $primaryKey = 'id_akun';

    public $timestamps = false;

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

    // Parent akun
    public function parent()
    {
        return $this->belongsTo(Akun::class, 'parent_id', 'id_akun');
    }

    // Child akun
    public function children()
    {
        return $this->hasMany(Akun::class, 'parent_id', 'id_akun');
    }

    // Mata uang
    public function mataUang()
    {
        return $this->belongsTo(MataUang::class, 'id_mata_uang', 'id_mata_uang');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
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

    public function scopeLatest($query)
    {
        return $query->orderBy('id_mata_uang', 'desc');
    }

    public function scopeLatestData($query)
    {
        return $query->orderBy('id_mata_uang', 'desc');
    }
}