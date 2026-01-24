<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban_mhs', function (Blueprint $table) {
            $table->id();

            // Kuis dan soal
            $table->foreignId('kuis_id')->constrained('kuis')->cascadeOnDelete();
            $table->foreignId('soal_id')->constrained('soal')->cascadeOnDelete();

            // Mahasiswa pembuat soal & penjawab
            $table->foreignId('pembuat_id')->constrained('kelas_mhs')->cascadeOnDelete();
            $table->foreignId('penjawab_id')->constrained('kelas_mhs')->cascadeOnDelete();

            // Jawaban mahasiswa
            $table->text('jawaban')->nullable(); // opsi/essay/isian
            $table->boolean('is_benar')->nullable(); // true/false jika objective

            // Poin / gamifikasi
            $table->integer('xp_penjawab')->default(0);  // xp mahasiswa yang menjawab
            $table->integer('xp_pembuat')->default(0);   // xp mahasiswa pembuat soal
            $table->integer('apresiasi_xp')->default(0); // xp tambahan dari dosen/mentor

            // Status approval untuk soal mahasiswa (jika soal buatan mhs)
            $table->tinyInteger('status')->default(0); // sesuai config/status_soal

            $table->timestamps();

            $table->unique(['penjawab_id', 'kuis_id', 'soal_id']); // mahasiswa hanya bisa submit 1x per soal di kuis
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_mhs');
    }
};
