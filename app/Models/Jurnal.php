<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */
    protected $table = 'jurnal';

    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */
    protected $primaryKey = 'id_jurnal';

    public $incrementing = true;

    protected $keyType = 'int';

    /*
    |--------------------------------------------------------------------------
    | TIMESTAMP
    |--------------------------------------------------------------------------
    */
    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | CASTING
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'tanggal'     => 'date:Y-m-d',
        'posted'      => 'boolean',
        'approved_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | DEFAULT ATTRIBUTE
    |--------------------------------------------------------------------------
    */
    protected $attributes = [
        'posted' => false,
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke periode
     */
    public function periode()
    {
        return $this->belongsTo(
            Periode::class,
            'id_periode',
            'id_periode'
        );
    }

    /**
     * Relasi ke perusahaan
     */
    public function perusahaan()
    {
        return $this->belongsTo(
            Perusahaan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }

    /**
     * Relasi creator
     */
    public function creator()
    {
        return $this->belongsTo(
            Pengguna::class,
            'created_by',
            'id_pengguna'
        );
    }

    /**
     * Relasi approver
     */
    public function approver()
    {
        return $this->belongsTo(
            Pengguna::class,
            'approved_by',
            'id_pengguna'
        );
    }

    /**
     * Relasi detail jurnal
     */
    public function details()
    {
        return $this->hasMany(
            JurnalDetail::class,
            'id_jurnal',
            'id_jurnal'
        );
    }

    /**
     * Relasi faktur penjualan
     */
    public function fakturPenjualan()
    {
        return $this->hasMany(
            FakturPenjualan::class,
            'id_jurnal',
            'id_jurnal'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    /**
     * Format tanggal
     */
    public function getTanggalFormatAttribute()
    {
        return date(
            'd-m-Y',
            strtotime($this->tanggal)
        );
    }

    /**
     * Status posting
     */
    public function getStatusPostingAttribute()
    {
        return $this->posted
            ? 'Posted'
            : 'Unposted';
    }

    /**
     * Status approval
     */
    public function getStatusApprovalAttribute()
    {
        return $this->approved_by
            ? 'Approved'
            : 'Pending';
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope posted
     */
    public function scopePosted($query)
    {
        return $query->where(
            'posted',
            true
        );
    }

    /**
     * Scope unposted
     */
    public function scopeUnposted($query)
    {
        return $query->where(
            'posted',
            false
        );
    }

    /**
     * Scope by periode
     */
    public function scopePeriode(
        $query,
        $idPeriode
    ) {
        return $query->where(
            'id_periode',
            $idPeriode
        );
    }

    /**
     * Scope by perusahaan
     */
    public function scopePerusahaan(
        $query,
        $idPerusahaan
    ) {
        return $query->where(
            'id_perusahaan',
            $idPerusahaan
        );
    }

    /**
     * Scope tipe jurnal
     */
    public function scopeTipe(
        $query,
        $tipe
    ) {
        return $query->where(
            'tipe_jurnal',
            $tipe
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * Cek posted
     */
    public function isPosted()
    {
        return $this->posted == true;
    }

    /**
     * Cek approved
     */
    public function isApproved()
    {
        return !is_null($this->approved_by);
    }

    /**
     * Total debit
     */
    public function getTotalDebitAttribute()
    {
        return $this->details->sum('debit');
    }

    /**
     * Total kredit
     */
    public function getTotalKreditAttribute()
    {
        return $this->details->sum('kredit');
    }
}
