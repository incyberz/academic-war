<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi_dosen', function (Blueprint $table) {
            $table->id();

            // FK ke pertemuan_kelas
            $table->foreignId('pertemuan_kelas_id')->constrained('pertemuan_kelas')->cascadeOnDelete();

            // FK ke dosen yang hadir
            $table->foreignId('dosen_id')->constrained('dosen')->cascadeOnDelete();

            // Timestamp saat dosen start perkuliahan
            $table->timestamp('start_at')->nullable();
            $table->integer('xp')->default(0);  // xp mahasiswa yang menjawab

            // Catatan tambahan / observasi dosen
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Unik: satu dosen per pertemuan_kelas
            $table->unique(['pertemuan_kelas_id', 'dosen_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_dosen');
    }
};
