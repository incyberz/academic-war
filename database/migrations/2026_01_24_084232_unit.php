<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit', function (Blueprint $table) {
            $table->id();

            // Relasi ke course
            $table->foreignId('course_id')
                ->constrained('course')
                ->cascadeOnDelete();

            // Identitas unit
            // $table->string('kode');              // contoh: U1, U2, HTML, LARAVEL
            $table->string('nama');              // contoh: Dasar HTML & CSS
            $table->text('deskripsi')->nullable();

            // Urutan sesuai MK
            $table->unsignedInteger('urutan');

            // Status
            $table->boolean('is_active')->default(true);

            // Audit
            $table->timestamps();

            // Constraint
            $table->unique(['course_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit');
    }
};
