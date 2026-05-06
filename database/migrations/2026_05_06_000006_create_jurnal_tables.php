<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jurnal', function (Blueprint $table) {
            $table->bigIncrements('id_jurnal');
            $table->string('nomor_jurnal', 50)->unique();
            $table->date('tanggal');
            $table->text('deskripsi');
            $table->enum('tipe_jurnal', ['Umum', 'Penyesuaian', 'Penutup', 'Pembalik', 'Kas Masuk', 'Kas Keluar', 'Bank']);
            $table->foreignId('id_periode')->constrained('periode', 'id_periode');
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan');
            $table->boolean('posted')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('pengguna', 'id_pengguna');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('created_by')->constrained('pengguna', 'id_pengguna');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};