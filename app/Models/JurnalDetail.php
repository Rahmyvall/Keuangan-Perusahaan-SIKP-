<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalDetail extends Model
{
    use HasFactory;

    protected $table = 'jurnal_detail';
    protected $primaryKey = 'id_detail';

    // Laravel otomatis mengisi created_at & updated_at
    public $timestamps = true;

    protected $fillable = [
        'id_jurnal',
        'id_akun',
        'debit',
        'kredit',
        'keterangan',
        'id_mata_uang',
        'kurs',
    ];

    protected $casts = [
        'debit'         => 'decimal:2',
        'kredit'        => 'decimal:2',
        'kurs'          => 'decimal:4',
        'id_jurnal'     => 'integer',
        'id_akun'       => 'integer',
        'id_mata_uang'  => 'integer',
    ];

    // Relationships
    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class, 'id_jurnal', 'id_jurnal');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    public function mataUang()
    {
        return $this->belongsTo(MataUang::class, 'id_mata_uang', 'id_mata_uang');
    }
}
