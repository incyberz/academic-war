<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_bimbingan', function (Blueprint $table) {
            $table->id(); // PK numeric default

            // FK ke mahasiswa
            $table->foreignId('mhs_id')
                ->constrained('mhs')
                ->cascadeOnDelete();

            // FK ke bimbingan
            $table->foreignId('bimbingan_id')
                ->constrained('bimbingan')
                ->cascadeOnDelete();

            // siapa yang menunjuk mahasiswa ini sebagai peserta bimbingan
            $table->foreignId('ditunjuk_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->integer('status')->default(1);

            // tambahan keterangan opsional
            $table->string('keterangan')->nullable();
            $table->unsignedTinyInteger('progress')
                ->default(0);

            $table->string('terakhir_topik')
                ->nullable();
            $table->timestamp('terakhir_bimbingan')
                ->nullable();

            $table->timestamp('terakhir_reviewed')
                ->nullable();

            $table->integer('current_tahapan_bimbingan_id')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_bimbingan');
    }
};
