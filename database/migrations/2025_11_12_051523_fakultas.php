<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jika tabel sudah ada, skip
        if (Schema::hasTable('fakultas')) {
            return;
        }

        Schema::create('fakultas', function (Blueprint $table) {
            $table->id(); // primary key numeric default
            $table->string('kode', 10)->unique(); // kode fakultas
            $table->tinyInteger('urutan')->nullable();
            $table->string('nama', 255);

            // Rule bimbingan
            $table->unsignedSmallInteger('batas_telat_bimbingan')->default(14); // hari
            $table->unsignedSmallInteger('batas_review_dosen')->default(7); // hari
            $table->unsignedSmallInteger('batas_kritis_bimbingan')->default(30); // hari
            $table->time('jam_awal_bimbingan')->default('08:00'); // jam awal bimbingan
            $table->time('jam_akhir_bimbingan')->default('21:00'); // jam akhir bimbingan
            $table->unsignedTinyInteger('max_bimbingan_per_minggu')->default(2);
            $table->unsignedTinyInteger('max_peserta_per_dosen')->default(10);
            $table->unsignedSmallInteger('max_durasi_menit_bimbingan')->default(60);
            $table->unsignedTinyInteger('max_bulan_masa_bimbingan')->default(12);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fakultas');
    }
};
