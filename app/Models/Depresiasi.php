<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depresiasi extends Model
{
    use HasFactory;

    protected $table = 'depresiasi';
    protected $primaryKey = 'id_depresiasi';

    public $timestamps = true;

    protected $fillable = [
        'id_aset',
        'id_jurnal',
        'periode_depresiasi',

        // snapshot aset
        'kode_aset',
        'nama_aset',
        'nilai_perolehan',
        'nilai_sisa',
        'masa_manfaat',

        // hasil hitung
        'nilai_depresiasi',
        'akumulasi_depresiasi',
        'nilai_buku',
    ];

    protected $casts = [
        'periode_depresiasi'   => 'date',
        'nilai_perolehan'      => 'decimal:2',
        'nilai_sisa'           => 'decimal:2',
        'nilai_depresiasi'     => 'decimal:2',
        'akumulasi_depresiasi' => 'decimal:2',
        'nilai_buku'           => 'decimal:2',
        'masa_manfaat'         => 'integer',
    ];

    /*
    |--------------------------------------
    | RELASI
    |--------------------------------------
    */

    public function aset()
    {
        return $this->belongsTo(AsetTetap::class, 'id_aset', 'id_aset');
    }

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class, 'id_jurnal', 'id_jurnal');
    }

    /*
    |--------------------------------------
    | ACCESSOR (opsional tapi berguna)
    |--------------------------------------
    */

    public function getNilaiDepresiasiFormatAttribute()
    {
        return number_format($this->nilai_depresiasi, 0, ',', '.');
    }

    public function getNilaiBukuFormatAttribute()
    {
        return number_format($this->nilai_buku, 0, ',', '.');
    }
}
