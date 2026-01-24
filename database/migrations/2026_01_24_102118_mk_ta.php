<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mk_ta', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mk_id')
                ->constrained('mk')
                ->cascadeOnDelete();

            $table->foreignId('tahun_ajar_id')
                ->constrained('tahun_ajar')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('sks'); // penyesuaian di TA tertentu


            $table->timestamps();

            // 1 MK hanya 1 kali per tahun ajar
            $table->unique(['mk_id', 'tahun_ajar_id']);

            $table->index('mk_id');
            $table->index('tahun_ajar_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mk_ta');
    }
};
