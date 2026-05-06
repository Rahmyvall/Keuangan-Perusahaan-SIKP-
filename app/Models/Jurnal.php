<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal';
    protected $primaryKey = 'id_jurnal';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nomor_jurnal',
        'tanggal',
        'deskripsi',
        'tipe_jurnal',
        'id_periode',
        'id_perusahaan',
        'posted',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'posted' => 'boolean',
        'approved_at' => 'datetime',
    ];

    /*
    |----------------------------------
    | RELASI
    |----------------------------------
    */

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function creator()
    {
        return $this->belongsTo(Pengguna::class, 'created_by', 'id_pengguna');
    }

    public function approver()
    {
        return $this->belongsTo(Pengguna::class, 'approved_by', 'id_pengguna');
    }

    public function details()
    {
        return $this->hasMany(JurnalDetail::class, 'id_jurnal', 'id_jurnal');
    }

    /*
    |----------------------------------
    | SCOPES
    |----------------------------------
    */

    public function scopePosted($query)
    {
        return $query->where('posted', true);
    }

    public function scopeUnposted($query)
    {
        return $query->where('posted', false);
    }

    public function scopePeriode($query, $idPeriode)
    {
        return $query->where('id_periode', $idPeriode);
    }
}
