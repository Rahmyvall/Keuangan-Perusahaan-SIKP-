<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Pengguna;
use App\Models\FakturPembelian;
use App\Models\Periode;
use App\Models\Supplier;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';
    protected $primaryKey = 'id_perusahaan';

    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = true;

    /**
     * MASS ASSIGNMENT
     */
    protected $fillable = [
        'nama_perusahaan',
        'npwp',
        'alamat',
        'kota',
        'telepon',
        'email',
        'logo',
        'status',
    ];

    /**
     * CASTING
     */
    protected $casts = [
        'id_perusahaan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function fakturPembelian()
    {
        return $this->hasMany(FakturPembelian::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function periodes()
    {
        return $this->hasMany(Periode::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function periodeAktif()
    {
        return $this->hasOne(Periode::class, 'id_perusahaan', 'id_perusahaan')
            ->where('status', 'Terbuka')
            ->latestOfMany();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    protected function npwp(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value) return null;

                $npwp = preg_replace('/\D/', '', $value);

                if (strlen($npwp) !== 15) {
                    return $value;
                }

                return substr($npwp, 0, 2) . '.' .
                       substr($npwp, 2, 3) . '.' .
                       substr($npwp, 5, 3) . '.' .
                       substr($npwp, 8, 1) . '-' .
                       substr($npwp, 9, 3) . '.' .
                       substr($npwp, 12, 3);
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ROUTE MODEL BINDING (IMPORTANT FIX)
    |--------------------------------------------------------------------------
    */

    public function getRouteKeyName()
    {
        return 'id_perusahaan';
    }
}
