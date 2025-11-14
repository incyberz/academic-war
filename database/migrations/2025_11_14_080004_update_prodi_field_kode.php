<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prodi', function (Blueprint $table) {
            $table->string('kode', 5)->change();      // update ke char(2)
            $table->string('nama', 30)->change();   // update ke varchar(30)
        });
    }

    public function down(): void
    {
        Schema::table('prodi', function (Blueprint $table) {
            // Kembalikan ke default sebelumnya (sesuai struktur awal Anda)
            $table->string('kode')->change();
            $table->string('nama')->change();
        });
    }
};
