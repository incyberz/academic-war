<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_bimbingan', function (Blueprint $table) {
            $table->id(); // primary key numeric default

            $table->string('kode', 20)->unique(); // kode jenis bimbingan, misal pkl, skripsi, kkn
            $table->string('nama', 100);          // nama lengkap jenis bimbingan
            $table->text('deskripsi')->nullable(); // deskripsi opsional

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_bimbingan');
    }
};
