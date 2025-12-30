<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sesi_bimbingan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peserta_bimbingan_id')
                ->constrained('peserta_bimbingan')
                ->cascadeOnDelete();

            $table->foreignId('tahapan_bimbingan_id')
                ->constrained('tahapan_bimbingan')
                ->cascadeOnDelete();

            $table->integer('status_sesi_bimbingan_id')->nullable();

            $table->text('pesan_mhs')->nullable();
            $table->text('pesan_dosen')->nullable();

            $table->string('file_bimbingan', 200)->nullable();
            $table->string('file_review', 200)->nullable();

            $table->timestamp('tanggal_review')->nullable();

            $table->timestamps();

            $table->foreign('status_sesi_bimbingan_id')
                ->references('id')
                ->on('status_sesi_bimbingan')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_bimbingan');
    }
};
