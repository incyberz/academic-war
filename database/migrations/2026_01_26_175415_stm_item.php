<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stm_item', function (Blueprint $table) {
            $table->id();

            // STM induk
            $table->foreignId('stm_id')
                ->constrained('stm')
                ->cascadeOnDelete();

            // MK dalam struktur kurikulum (legitimasi akademik)
            $table->foreignId('kur_mk_id')
                ->constrained('kur_mk')
                ->restrictOnDelete();

            // kelas aktual (prodi + semester + shift + rombel + TA)
            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            // LMS Course (opsional)
            $table->foreignId('course_id')
                ->nullable()
                ->constrained('course')
                ->nullOnDelete();

            // SKS sesuai STM (boleh null → fallback ke mk.sks)
            $table->unsignedTinyInteger('sks_tugas')->nullable();

            // SKS beban kerja akademik (BKD)
            $table->unsignedTinyInteger('sks_beban')->nullable();

            // SKS untuk honor dosen
            $table->unsignedTinyInteger('sks_honor')->nullable();

            $table->timestamps();

            // satu kelas hanya boleh muncul sekali untuk satu MK di satu STM
            $table->unique([
                'stm_id',
                'kur_mk_id',
                'kelas_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stm_item');
    }
};
