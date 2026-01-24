<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soal', function (Blueprint $table) {
            $table->id();

            // Induk unit / pertemuan
            $table->foreignId('unit_id')->constrained('unit')->cascadeOnDelete();

            // Pembuat soal
            $table->foreignId('dosen_id')->nullable()->constrained('dosen')->nullOnDelete();
            $table->foreignId('mhs_id')->nullable()->constrained('mhs')->nullOnDelete();

            // Konten soal
            $table->text('pertanyaan');
            $table->text('opsies')->nullable();     // PG, MA, TF: "Opsi A;Opsi B;Opsi C"
            $table->text('answers')->nullable();    // jawaban benar: "Opsi A;Opsi C"

            $table->string('jenis', 10);            // TF, PG, MA, IS, ES
            $table->integer('bobot')->default(0);
            $table->integer('xp')->default(100);    // upah tanam soal terendah
            $table->integer('xp_growth')->default(0); // akumulasi xp soal aktif
            $table->integer('max_opsi')->default(0);
            $table->string('emoji', 10)->nullable();
            $table->string('bg', 50)->nullable();
            $table->string('tags')->nullable();      // wajib mengandung tag pertemuan/unit

            // Gamifikasi / workflow
            $table->tinyInteger('status')->default(0); // sesuai config/status_soal
            $table->unsignedSmallInteger('approved_by_community_count')->default(0);
            $table->unsignedSmallInteger('reject_count')->default(0);

            // Analitik
            $table->unsignedSmallInteger('durasi_jawab')->default(30); // detik
            $table->unsignedTinyInteger('level_soal')->default(1);     // dinamis, max 100
            $table->decimal('bs_count', 5, 2)->default(0);             // rasio dijawab benar / dijawab salah

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};
