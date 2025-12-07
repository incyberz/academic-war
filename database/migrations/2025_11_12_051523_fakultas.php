<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jika tabel sudah ada, skip
        if (Schema::hasTable('fakultas')) {
            return;
        }

        Schema::create('fakultas', function (Blueprint $table) {
            $table->string('fakultas', 10)->primary();
            $table->tinyInteger('urutan')->nullable();
            $table->string('nama', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fakultas');
    }
};
