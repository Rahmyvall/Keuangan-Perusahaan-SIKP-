<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->id('id_akun');
            $table->string('kode_akun', 20)->unique();
            $table->string('nama_akun', 150);
            $table->enum('tipe_akun', ['Aset', 'Liabilitas', 'Ekuitas', 'Pendapatan', 'Beban']);
            $table->string('sub_tipe', 50)->nullable();
            $table->enum('saldo_normal', ['Debit', 'Kredit']);
            $table->integer('level')->default(1);
            $table->foreignId('parent_id')->nullable()->constrained('akun', 'id_akun')->nullOnDelete();
            $table->foreignId('id_mata_uang')->default(1)->constrained('mata_uang', 'id_mata_uang');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
