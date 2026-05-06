<?php

namespace Database\Seeders;

use App\Models\Perusahaan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerusahaanSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan sementara foreign key check (agar truncate aman)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus semua data lama + reset auto increment
        Perusahaan::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insert data
        Perusahaan::create([
            'id_perusahaan'   => 1,
            'nama_perusahaan' => 'PT Demo ERP',
            // created_at & updated_at otomatis diisi oleh Laravel
        ]);

        $this->command->info('PerusahaanSeeder berhasil dijalankan ✅');
    }
}