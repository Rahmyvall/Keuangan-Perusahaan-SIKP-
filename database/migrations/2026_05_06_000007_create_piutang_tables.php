<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('kode_pelanggan', 20)->unique()->nullable();
            $table->string('nama_pelanggan', 150);
            $table->text('alamat')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->decimal('limit_kredit', 18, 2)->default(0);
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan')->cascadeOnDelete();
        });

        Schema::create('faktur_penjualan', function (Blueprint $table) {
            $table->id('id_faktur_penjualan')->bigIncrements();
            $table->string('nomor_faktur', 50)->unique();
            $table->date('tanggal');
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan');
            $table->foreignId('id_jurnal')->nullable()->constrained('jurnal', 'id_jurnal');
            $table->decimal('subtotal', 18, 2);
            $table->decimal('ppn', 18, 2)->default(0);
            $table->decimal('total', 18, 2);
            $table->enum('status', ['Belum Lunas', 'Lunas', 'Dibatalkan'])->default('Belum Lunas');
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan');
        });

        Schema::create('penerimaan_piutang', function (Blueprint $table) {
            $table->id('id_penerimaan')->bigIncrements();
            $table->string('nomor_penerimaan', 50)->unique();
            $table->date('tanggal');
            $table->foreignId('id_faktur_penjualan')->constrained('faktur_penjualan', 'id_faktur_penjualan');
            $table->foreignId('id_jurnal')->nullable()->constrained('jurnal', 'id_jurnal');
            $table->decimal('jumlah', 18, 2);
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerimaan_piutang');
        Schema::dropIfExists('faktur_penjualan');
        Schema::dropIfExists('pelanggan');
    }
};
