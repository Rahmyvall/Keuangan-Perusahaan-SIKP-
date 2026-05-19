<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiRekeningBank extends Model
{
    protected $table = 'mutasi_rekening_bank';
    protected $primaryKey = 'id_mutasi';

    protected $fillable = [
        'id_rekening',
        'tipe',
        'jumlah',
        'saldo_sebelum',
        'saldo_sesudah',
        'keterangan',
        'id_perusahaan',
    ];

    public function rekening()
    {
        return $this->belongsTo(RekeningBank::class, 'id_rekening', 'id_rekening');
    }
}
