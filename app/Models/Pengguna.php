<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    public $timestamps = true; // pastikan tabel punya created_at & updated_at

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
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | CUSTOM PASSWORD FIELD
    |--------------------------------------------------------------------------
    */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /*
    |--------------------------------------------------------------------------
    | USERNAME LOGIN FIELD (PENTING)
    |--------------------------------------------------------------------------
    */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /*
    |--------------------------------------------------------------------------
    | CEK USER AKTIF
    |--------------------------------------------------------------------------
    */
    public function isActive()
    {
        return $this->is_active == 1;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER ROLE
    |--------------------------------------------------------------------------
    */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }
}