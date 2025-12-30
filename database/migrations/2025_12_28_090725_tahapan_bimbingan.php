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

            // urutan workflow
            $table->unsignedSmallInteger('urutan');

            // nama tahapan
            $table->string('nama_tahapan', 30);

            // deskripsi / penjelasan tahapan
            $table->text('keterangan')->nullable();

            // status aktif / nonaktif
            $table->boolean('is_active')->default(true);

            // FK ke jenis bimbingan
            $table->foreignId('jenis_bimbingan_id')
                ->constrained('jenis_bimbingan')
                ->cascadeOnDelete();

            $table->timestamps();

            // unique per jenis bimbingan
            $table->unique(['jenis_bimbingan_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahapan_bimbingan');
    }
};
