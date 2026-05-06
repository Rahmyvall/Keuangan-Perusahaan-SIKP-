<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';
    protected $primaryKey = 'id_perusahaan';

    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = true;

    /**
     * FIELD YANG BOLEH DIISI
     */
    protected $fillable = [
        'nama_perusahaan',
        'npwp',
        'alamat',
        'kota',
        'telepon',
        'email',
        'logo',
    ];

    /**
     * CASTING DATA
     */
    protected $casts = [
        'id_perusahaan' => 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /**
     * RELASI
     */
    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_perusahaan', 'id_perusahaan');
    }

    /**
     * SCOPES
     */
    public function scopeTerbaru($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * ACCESSOR NPWP (optional aman)
     */
    protected function npwp(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $npwp = preg_replace('/[^0-9]/', '', $value);

                if (strlen($npwp) == 15) {
                    return substr($npwp, 0, 2) . '.' .
                        substr($npwp, 2, 3) . '.' .
                        substr($npwp, 5, 3) . '.' .
                        substr($npwp, 8, 1) . '-' .
                        substr($npwp, 9, 3) . '.' .
                        substr($npwp, 12, 3);
                }

                return $value;
            }
        );
    }

    public function periodes()
    {
        return $this->hasMany(Periode::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function periodeAktif()
    {
        return $this->periodes()->where('status', 'Terbuka')->latest();
    }
}