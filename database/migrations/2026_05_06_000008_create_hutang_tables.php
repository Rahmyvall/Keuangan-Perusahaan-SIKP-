<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id('id_supplier');
            $table->string('kode_supplier', 20)->unique()->nullable();
            $table->string('nama_supplier', 150);
            $table->text('alamat')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan')->cascadeOnDelete();
        });

        Schema::create('faktur_pembelian', function (Blueprint $table) {
            $table->id('id_faktur_pembelian')->bigIncrements();
            $table->string('nomor_faktur', 50)->unique();
            $table->date('tanggal');
            $table->foreignId('id_supplier')->constrained('supplier', 'id_supplier');
            $table->foreignId('id_jurnal')->nullable()->constrained('jurnal', 'id_jurnal');
            $table->decimal('subtotal', 18, 2);
            $table->decimal('ppn', 18, 2)->default(0);
            $table->decimal('total', 18, 2);
            $table->enum('status', ['Belum Lunas', 'Lunas', 'Dibatalkan'])->default('Belum Lunas');
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan');
        });

        Schema::create('pembayaran_hutang', function (Blueprint $table) {
            $table->id('id_pembayaran')->bigIncrements();
            $table->string('nomor_pembayaran', 50)->unique();
            $table->date('tanggal');
            $table->foreignId('id_faktur_pembelian')->constrained('faktur_pembelian', 'id_faktur_pembelian');
            $table->foreignId('id_jurnal')->nullable()->constrained('jurnal', 'id_jurnal');
            $table->decimal('jumlah', 18, 2);
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_hutang');
        Schema::dropIfExists('faktur_pembelian');
        Schema::dropIfExists('supplier');
    }
};
