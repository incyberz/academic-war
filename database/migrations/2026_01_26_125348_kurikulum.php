<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulum', function (Blueprint $table) {
            $table->id();

            // $table->string('nama')->unique(); // auto, by getNamaAttribute
            // contoh: "Kurikulum Sistem Informasi 2025"

            $table->year('tahun');
            // tahun penetapan kurikulum, misal: 2025

            $table->foreignId('prodi_id')
                ->constrained('prodi')
                ->cascadeOnDelete();

            $table->boolean('is_active')->default(true);
            // menandai kurikulum yang sedang digunakan

            $table->text('keterangan')->nullable();
            // catatan tambahan / SK / dasar penetapan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};
