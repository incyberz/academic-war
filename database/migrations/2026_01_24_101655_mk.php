<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mk', function (Blueprint $table) {
            $table->id();

            // identitas resmi mata kuliah
            $table->string('kode')->unique();
            $table->string('nama');
            $table->unsignedTinyInteger('sks');

            // deskripsi singkat (opsional)
            $table->text('deskripsi')->nullable();

            // status aktif / tidak (untuk reuse)
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // optimasi
            $table->index('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mk');
    }
};
