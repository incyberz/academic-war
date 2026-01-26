<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stm', function (Blueprint $table) {
            $table->id();

            // tahun ajar STM berlaku
            $table->foreignId('tahun_ajar_id')
                ->constrained('tahun_ajar')
                ->cascadeOnDelete();

            // dosen yang diberi tugas
            $table->foreignId('dosen_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // unit yang memberi tugas (prodi / fakultas / sekolah tinggi)
            $table->foreignId('unit_penugasan_id')
                ->constrained('unit_penugasan')
                ->restrictOnDelete();

            // metadata surat
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_surat')->nullable();

            // penandatangan (snapshot legal)
            $table->string('penandatangan_nama')->nullable();
            $table->string('penandatangan_jabatan')->nullable();
            $table->uuid('uuid')->unique();

            // rekap SKS (snapshot, sumber utama ada di stm_mk)
            $table->unsignedTinyInteger('total_sks_tugas')->nullable();
            $table->unsignedTinyInteger('total_sks_beban')->nullable();
            $table->unsignedTinyInteger('total_sks_honor')->nullable();

            // status administrasi
            $table->enum('status', [
                'draft',
                'disahkan'
            ])->default('draft');

            $table->timestamps();

            // satu dosen hanya boleh punya satu STM per tahun ajar
            $table->unique([
                'tahun_ajar_id',
                'dosen_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stm');
    }
};
