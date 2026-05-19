<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekeningBank extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'rekening_bank';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_rekening';

    /**
     * Karena tidak ada timestamps pada migration
     */
    public $timestamps = false;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'nama_rekening',
        'id_akun_kas',
        'saldo_awal',
        'id_perusahaan',
    ];

    /**
     * Casting data
     */
    protected $casts = [
        'saldo_awal' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke tabel akun
     */
    public function akunKas()
    {
        return $this->belongsTo(Akun::class, 'id_akun_kas', 'id_akun');
    }

    /**
     * Relasi ke tabel perusahaan
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
    public function mutasi()
    {
        return $this->hasMany(MutasiRekeningBank::class, 'id_rekening', 'id_rekening');
    }
}