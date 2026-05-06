<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    // TIMESTAMPS DINONAKTIFKAN karena tabel tidak punya kolom created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'id_perusahaan',
        'nama_lengkap',
        'username',
        'password_hash',
        'email',
        'role',
        'is_active'
    ];

    protected $hidden = [
        'password_hash',
    ];

    /*
    |--------------------------------------
    | CASTING
    |--------------------------------------
    */
    protected $casts = [
        'is_active' => 'boolean',
        // created_at & updated_at dihapus karena kolom tidak ada di tabel
    ];

    /*
    |--------------------------------------
    | AUTH PASSWORD FIELD
    |--------------------------------------
    */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /*
    |--------------------------------------
    | RELASI PERUSAHAAN
    |--------------------------------------
    */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    /*
    |--------------------------------------
    | HELPER STATUS
    |--------------------------------------
    */
    public function isActive()
    {
        return (bool) $this->is_active;
    }

    /*
    |--------------------------------------
    | ROLE CHECK
    |--------------------------------------
    */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAkuntan()
    {
        return $this->role === 'akuntan';
    }

    public function isManajer()
    {
        return $this->role === 'manajer';
    }

    public function isAuditor()
    {
        return $this->role === 'auditor';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }
}