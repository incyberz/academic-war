<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuis_soal', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kuis_id')->constrained('kuis')->cascadeOnDelete();
            $table->foreignId('soal_id')->constrained('soal')->cascadeOnDelete();

            $table->unsignedSmallInteger('urutan')->nullable();  // urutan soal di kuis, optional

            $table->timestamps();

            $table->unique(['kuis_id', 'soal_id']); // agar soal tidak double di kuis yang sama
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuis_soal');
    }
};
