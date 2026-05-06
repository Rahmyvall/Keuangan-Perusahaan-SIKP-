<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->id('id_periode');
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan')->cascadeOnDelete();
            $table->integer('tahun');
            $table->integer('bulan')->check('bulan between 1 and 12');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->enum('status', ['Terbuka', 'Ditutup', 'Dikunci'])->default('Terbuka');
            $table->timestamps();

            $table->unique(['id_perusahaan', 'tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
