<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi_offline', function (Blueprint $table) {
            $table->id();

            // FK ke sesi_kelas
            $table->foreignId('sesi_kelas_id')->constrained('sesi_kelas')->cascadeOnDelete();

            // FK ke kelas_mhs (peserta mahasiswa)
            $table->foreignId('kelas_mhs_id')->constrained('kelas_mhs')->cascadeOnDelete();

            // Status sesi (mengacu ke config/status_presensi_offline.php)
            $table->integer('status')->nullable();


            // XP yang diterima mahasiswa dari presensi offline
            $table->integer('xp')->default(0);

            // Catatan opsional dari dosen
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Unik: satu mahasiswa per sesi_kelas
            $table->unique(['sesi_kelas_id', 'kelas_mhs_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_offline');
    }
};
