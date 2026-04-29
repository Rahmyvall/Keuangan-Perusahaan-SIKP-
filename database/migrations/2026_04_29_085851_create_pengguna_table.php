<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->increments('id_pengguna');

            $table->unsignedInteger('id_perusahaan');

            $table->string('nama_lengkap', 100);
            $table->string('username', 50)->unique();
            $table->string('password_hash', 255);

            $table->string('email', 100)->nullable();

            $table->enum('role', ['admin', 'akuntan', 'manajer', 'auditor', 'staff']);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            // ini otomatis created_at & updated_at

            // Foreign key
            $table->foreign('id_perusahaan')
                ->references('id_perusahaan')
                ->on('perusahaan')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};