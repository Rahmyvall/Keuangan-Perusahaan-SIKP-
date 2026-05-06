<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode', function (Blueprint $table) {
            // Primary Key - pakai integer agar sesuai SQL asli
            $table->integer('id_periode')->autoIncrement()->primary();

            // Foreign key ke perusahaan
            $table->unsignedInteger('id_perusahaan');

            $table->integer('tahun');
            $table->tinyInteger('bulan');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');

            $table->enum('status', ['Terbuka', 'Ditutup', 'Dikunci'])
                  ->default('Terbuka');

            // Foreign Key
            $table->foreign('id_perusahaan')
                  ->references('id_perusahaan')
                  ->on('perusahaan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Unique
            $table->unique(['id_perusahaan', 'tahun', 'bulan']);

            $table->timestamps();
        });

        // CHECK Constraint (lebih aman)
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE periode ADD CONSTRAINT chk_bulan 
                            CHECK (bulan BETWEEN 1 AND 12)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};