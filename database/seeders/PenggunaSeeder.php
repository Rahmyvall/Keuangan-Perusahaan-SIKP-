<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id_perusahaan' => 1,
                'nama_lengkap' => 'Super Admin',
                'username' => 'superadmin',
                'password_hash' => Hash::make('admin'),
                'email' => 'superadmin@gmail.com',
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'id_perusahaan' => 1,
                'nama_lengkap' => 'Kepala Akuntansi',
                'username' => 'akuntan',
                'password_hash' => Hash::make('akuntansi'),
                'email' => 'akuntan@gmail.com',
                'role' => 'akuntan',
                'is_active' => true,
            ],
            [
                'id_perusahaan' => 1,
                'nama_lengkap' => 'Manajer Keuangan',
                'username' => 'manajer',
                'password_hash' => Hash::make('manajer'),
                'email' => 'manajer@gmail.com',
                'role' => 'manajer',
                'is_active' => true,
            ],
            [
                'id_perusahaan' => 1,
                'nama_lengkap' => 'Auditor Internal',
                'username' => 'auditor',
                'password_hash' => Hash::make('auditor'),
                'email' => 'auditor@gmail.com',
                'role' => 'auditor',
                'is_active' => true,
            ],
            [
                'id_perusahaan' => 1,
                'nama_lengkap' => 'Staff Operasional',
                'username' => 'staff',
                'password_hash' => Hash::make('staff'),
                'email' => 'staff@gmail.com',
                'role' => 'staff',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            Pengguna::create($user);
        }
    }
}