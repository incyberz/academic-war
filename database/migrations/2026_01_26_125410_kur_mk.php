<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kur_mk', function (Blueprint $table) {
            $table->id();

            // relasi ke kurikulum
            $table->foreignId('kurikulum_id')
                ->constrained('kurikulum')
                ->cascadeOnDelete();

            // relasi ke mata kuliah
            $table->foreignId('mk_id')
                ->constrained('mk')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('semester');
            // semester ideal MK di kurikulum (1–8)

            $table->enum('jenis', ['wajib', 'pilihan'])->default('wajib');

            $table->foreignId('prasyarat_mk_id')
                ->nullable()
                ->constrained('mk')
                ->nullOnDelete();
            // MK prasyarat (opsional)

            $table->timestamps();

            // mencegah MK dobel di kurikulum yang sama
            $table->unique(['kurikulum_id', 'mk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kur_mk');
    }
};
