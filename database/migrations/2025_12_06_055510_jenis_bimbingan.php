<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_bimbingan', function (Blueprint $table) {
            // PK berupa kode, misalnya: pkl, skripsi, kkn
            $table->string('jenis_bimbingan', 20)->primary();

            // nama lengkap jenis bimbingan
            $table->string('nama', 100);

            // deskripsi opsional
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_bimbingan');
    }
};
