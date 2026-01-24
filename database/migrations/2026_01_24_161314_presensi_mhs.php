<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi_mhs', function (Blueprint $table) {
            $table->id();

            // FK ke pertemuan_kelas
            $table->foreignId('pertemuan_kelas_id')->constrained('pertemuan_kelas')->cascadeOnDelete();

            // FK ke kelas_mhs (peserta mahasiswa)
            $table->foreignId('kelas_mhs_id')->constrained('kelas_mhs')->cascadeOnDelete();

            // Waktu hadir (otomatis)
            $table->timestamp('waktu')->nullable();

            // XP yang diterima mahasiswa untuk presensi
            $table->unsignedInteger('xp')->default(0);

            // Catatan opsional
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Unik: satu mahasiswa per pertemuan_kelas
            $table->unique(['pertemuan_kelas_id', 'kelas_mhs_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_mhs');
    }
};
