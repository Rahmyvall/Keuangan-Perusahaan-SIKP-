<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan')->cascadeOnDelete();
            $table->string('nama_lengkap', 100);
            $table->string('username', 50)->unique();
            $table->string('password_hash', 255);
            $table->string('email', 100)->nullable();
            $table->enum('role', ['admin', 'akuntan', 'manajer', 'auditor', 'staff']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
