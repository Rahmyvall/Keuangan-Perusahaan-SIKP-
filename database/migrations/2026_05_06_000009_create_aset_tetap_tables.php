<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aset_tetap', function (Blueprint $table) {
            $table->id('id_aset');
            $table->string('kode_aset', 30)->unique();
            $table->string('nama_aset', 150);
            $table->foreignId('id_akun_aset')->constrained('akun', 'id_akun');
            $table->date('tanggal_pengadaan');
            $table->decimal('nilai_perolehan', 18, 2);
            $table->integer('masa_manfaat');
            $table->decimal('nilai_sisa', 18, 2)->default(0);
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan')->cascadeOnDelete();
        });

        Schema::create('depresiasi', function (Blueprint $table) {
            $table->id('id_depresiasi')->bigIncrements();
            $table->foreignId('id_aset')->constrained('aset_tetap', 'id_aset')->cascadeOnDelete();
            $table->foreignId('id_jurnal')->nullable()->constrained('jurnal', 'id_jurnal');
            $table->date('periode_depresiasi');
            $table->decimal('nilai_depresiasi', 18, 2);
        });

        Schema::create('rekening_bank', function (Blueprint $table) {
            $table->id('id_rekening');
            $table->string('nama_bank', 100);
            $table->string('nomor_rekening', 50)->unique();
            $table->string('nama_rekening', 100);
            $table->foreignId('id_akun_kas')->constrained('akun', 'id_akun');
            $table->decimal('saldo_awal', 18, 2)->default(0);
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekening_bank');
        Schema::dropIfExists('depresiasi');
        Schema::dropIfExists('aset_tetap');
    }
};
