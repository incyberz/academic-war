<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();

            // kode kelas utuh (misal: S1-SI-A-R-7-20251)
            $table->string('kode')->unique();

            // label singkat untuk UI (misal: SI-R7)
            $table->string('label');

            // relasi akademik
            $table->foreignId('tahun_ajar_id')
                ->constrained('tahun_ajar')
                ->cascadeOnDelete();

            $table->foreignId('prodi_id')
                ->constrained('prodi')
                ->cascadeOnDelete();

            $table->foreignId('shift_id')
                ->constrained('shift')
                ->cascadeOnDelete();

            // identitas kelas
            $table->string('rombel', 5);              // A, B, dst
            $table->unsignedTinyInteger('semester');  // 1–14

            // kapasitas kelas
            $table->unsignedSmallInteger('max_peserta')->default(40);
            $table->unsignedSmallInteger('min_peserta')->default(5);

            $table->timestamps();

            /**
             * Unique constraint berbasis relasi:
             * Dalam 1 TA + prodi + shift + semester,
             * rombel tidak boleh sama
             */
            $table->unique([
                'tahun_ajar_id',
                'prodi_id',
                'shift_id',
                'semester',
                'rombel'
            ]);

            // index bantu query
            $table->index(['tahun_ajar_id', 'prodi_id']);
            $table->index(['semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
