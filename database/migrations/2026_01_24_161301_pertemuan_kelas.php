<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertemuan_kelas', function (Blueprint $table) {
            $table->id();

            // Relasi ke pertemuan_ta
            $table->foreignId('pertemuan_ta_id')->constrained('pertemuan_ta')->cascadeOnDelete();

            // Relasi ke kelas
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();

            // Catatan dosen: selingan ajar, rencana tambahan, dll
            $table->text('catatan_dosen')->nullable();

            // Waktu mulai / pindah jadwal
            $table->timestamp('start_at')->nullable();

            // Status pertemuan (mengacu ke config/status_pertemuan_kelas.php)
            $table->integer('status')->default(0);

            $table->timestamps();

            // Unik per pertemuan_ta + kelas
            $table->unique(['pertemuan_ta_id', 'kelas_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertemuan_kelas');
    }
};
