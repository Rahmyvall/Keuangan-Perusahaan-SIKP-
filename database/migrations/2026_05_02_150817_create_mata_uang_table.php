<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_uang', function (Blueprint $table) {
            $table->id('id_mata_uang'); // AUTO_INCREMENT PRIMARY KEY
            $table->string('kode', 3)->unique(); // IDR, USD, dll
            $table->string('nama', 50);
            $table->string('simbol', 10)->nullable(); // optional
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_uang');
    }
};
