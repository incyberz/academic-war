<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_penugasan', function (Blueprint $table) {
            $table->id();

            // kode singkat unit (dipakai di nomor surat / laporan)
            $table->string('kode', 20)->unique();
            // contoh: STIKOM, FT, FKOM, IF, SI, KA

            // nama resmi unit
            $table->string('nama');
            // contoh: Program Studi Sistem Informasi

            // tipe / level unit
            $table->enum('tipe', [
                'universitas',
                'sekolah_tinggi',
                'fakultas',
                'jurusan',
                'prodi',
                'unit_lain'
            ]);

            // hirarki organisasi (misal prodi di bawah fakultas)
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('unit_penugasan')
                ->nullOnDelete();

            // flag aktif/non-aktif (untuk arsip tanpa hapus data)
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // index bantu query struktur organisasi
            $table->index(['tipe']);
            $table->index(['parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_penugasan');
    }
};
