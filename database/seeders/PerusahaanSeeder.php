<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerusahaanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('perusahaan')->insert([
            'id_perusahaan' => 1,
            'nama_perusahaan' => 'PT Demo ERP',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}