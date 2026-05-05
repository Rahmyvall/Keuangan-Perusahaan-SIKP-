<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
    $table->id('id_akun');
    $table->string('kode_akun', 20)->unique();
    $table->string('nama_akun', 150);

    $table->enum('tipe_akun', [
        'Aset',
        'Liabilitas',
        'Ekuitas',
        'Pendapatan',
        'Beban'
    ]);

    $table->string('sub_tipe', 50)->nullable();
    $table->enum('saldo_normal', ['Debit', 'Kredit']);
    $table->integer('level')->default(1);

    $table->unsignedBigInteger('parent_id')->nullable();
    $table->unsignedBigInteger('id_mata_uang')->default(1);

    $table->boolean('is_active')->default(true);
    $table->timestamp('created_at')->useCurrent();

    $table->foreign('parent_id')
          ->references('id_akun')
          ->on('akun')
          ->nullOnDelete(); // lebih aman daripada cascade

    $table->foreign('id_mata_uang')
          ->references('id_mata_uang')
          ->on('mata_uang')
          ->restrictOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
