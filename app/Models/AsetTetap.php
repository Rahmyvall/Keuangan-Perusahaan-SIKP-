<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetTetap extends Model
{
    use HasFactory;

    protected $table = 'aset_tetap';

    protected $primaryKey = 'id_aset';

    public $timestamps = false;

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'id_akun_aset',
        'tanggal_pengadaan',
        'nilai_perolehan',
        'masa_manfaat',
        'nilai_sisa',
        'id_perusahaan',
    ];

    protected $casts = [
        'tanggal_pengadaan' => 'date',
        'nilai_perolehan' => 'decimal:2',
        'nilai_sisa' => 'decimal:2',
        'masa_manfaat' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function akunAset()
    {
        return $this->belongsTo(Akun::class, 'id_akun_aset', 'id_akun');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}