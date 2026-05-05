<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('mata_uang', function (Blueprint $table) {
        $table->timestamps();        // menambahkan created_at & updated_at
        // $table->softDeletes();    // jika butuh soft delete
    });
}

public function down()
{
    Schema::table('mata_uang', function (Blueprint $table) {
        $table->dropTimestamps();
    });
}
};