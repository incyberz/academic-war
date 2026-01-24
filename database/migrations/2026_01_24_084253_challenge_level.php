<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenge_level', function (Blueprint $table) {
            $table->id();

            // relasi ke challenge
            $table->foreignId('challenge_id')
                ->constrained('challenge')
                ->cascadeOnDelete();

            // XP level (override penuh, jadi sumber kebenaran)
            $table->unsignedInteger('xp')->default(0);

            // tujuan / target capaian level ini
            $table->text('objective')->nullable();

            $table->timestamps();

            // optimasi query
            $table->index('challenge_id');
            $table->index('xp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_level');
    }
};
