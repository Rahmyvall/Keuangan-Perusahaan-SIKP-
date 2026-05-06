<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('saldo_awal', function (Blueprint $table) {
            $table->id('id_saldo');
            $table->foreignId('id_akun')->constrained('akun', 'id_akun');
            $table->foreignId('id_periode')->constrained('periode', 'id_periode');
            $table->decimal('debit', 18, 2)->default(0);
            $table->decimal('kredit', 18, 2)->default(0);

            $table->unique(['id_akun', 'id_periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldo_awal');
    }
};
