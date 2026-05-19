<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasi_rekening_bank', function (Blueprint $table) {

            $table->bigIncrements('id_mutasi');

            // Relasi ke rekening bank
            $table->foreignId('id_rekening')
                ->constrained('rekening_bank', 'id_rekening')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Jenis transaksi
            $table->enum('tipe', ['DEBIT', 'KREDIT']);

            // Nominal transaksi
            $table->decimal('jumlah', 18, 2);

            // Saldo sebelum & sesudah transaksi
            $table->decimal('saldo_sebelum', 18, 2);
            $table->decimal('saldo_sesudah', 18, 2);

            // Keterangan transaksi
            $table->string('keterangan')->nullable();

            // Multi perusahaan (ERP ready)
            $table->foreignId('id_perusahaan')
                ->constrained('perusahaan', 'id_perusahaan')
                ->cascadeOnDelete();

            $table->timestamps();

            // INDEX untuk performa query
            $table->index('id_rekening');
            $table->index('id_perusahaan');
            $table->index('tipe');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_rekening_bank');
    }
};
