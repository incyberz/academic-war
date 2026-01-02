<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bab_laporan', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 10); // BAB I, BAB II, dst
            $table->string('nama', 100); // Pendahuluan, Metodologi, dll
            $table->boolean('is_inti')->default(true);
            $table->unsignedTinyInteger('urutan'); // urutan tampil & progres

            $table->text('deskripsi')->nullable(); // opsional (penjelasan bab)

            $table->timestamps();

            $table->unique('kode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bab_laporan');
    }
};
