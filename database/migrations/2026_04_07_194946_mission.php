<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained('skill')->cascadeOnDelete();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['upload', 'checklist', 'auto'])->default('upload');
            $table->unsignedInteger('xp')->default(0);
            $table->unsignedInteger('urutan')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mission');
    }
};
