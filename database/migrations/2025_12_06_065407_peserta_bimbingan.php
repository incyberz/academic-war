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

            $table->dateTime('tanggal_penunjukan')->useCurrent();

            $table->string('jenis_bimbingan', 30);

            // status peserta -> FK numeric ke tabel status_peserta_bimbingan (default 1 = aktif)
            $table->foreignId('status_peserta_bimbingan_id')
                ->default(1)
                ->constrained('status_peserta_bimbingan')
                ->restrictOnDelete();

            // tambahan keterangan opsional
            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_bimbingan');
    }
};
