<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahapan_bimbingan', function (Blueprint $table) {
            $table->id();

            // urutan tahap (untuk sorting workflow)
            $table->unsignedSmallInteger('urutan');

            // nama tahap
            $table->string('tahap', 30);

            // FK ke jenis_bimbingan
            $table->foreignId('jenis_bimbingan_id')
                ->constrained('jenis_bimbingan')
                ->cascadeOnDelete();

            $table->timestamps();

            // optional tapi sangat disarankan
            $table->unique(['jenis_bimbingan_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahapan_bimbingan');
    }
};
