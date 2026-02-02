<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi-dosen', function (Blueprint $table) {
            $table->id();

            // FK ke sesi_kelas
            $table->foreignId('sesi_kelas_id')->constrained('sesi_kelas')->cascadeOnDelete();

            // FK ke dosen yang hadir
            $table->foreignId('dosen_id')->constrained('dosen')->cascadeOnDelete();

            // Timestamp saat dosen start perkuliahan
            $table->timestamp('start_at')->nullable();
            $table->integer('xp')->default(0);  // xp mahasiswa yang menjawab

            // Catatan tambahan / observasi dosen
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Unik: satu dosen per sesi_kelas
            $table->unique(['sesi_kelas_id', 'dosen_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi-dosen');
    }
};
