<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();

            // Relasi ke unit/pertemuan
            $table->foreignId('unit_id')->constrained('unit')->cascadeOnDelete();

            // Judul kuis
            $table->string('judul');

            // Jumlah soal default yang dimuat saat mahasiswa main kuis
            $table->unsignedSmallInteger('jumlah_soal')->default(10);

            // Dibuat oleh dosen
            $table->foreignId('dosen_id')->constrained('dosen')->cascadeOnDelete();

            // Opsional: durasi kuis (menit)
            $table->unsignedSmallInteger('durasi_menit')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuis');
    }
};
