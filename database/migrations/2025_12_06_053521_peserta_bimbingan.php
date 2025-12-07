<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_bimbingan', function (Blueprint $table) {
            $table->id();

            // FK ke mahasiswa
            $table->foreignId('mhs_id')
                ->constrained('mhs')
                ->onDelete('cascade');

            // siapa yang menunjuk mahasiswa ini sebagai peserta bimbingan
            $table->foreignId('ditunjuk_oleh')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->dateTime('tanggal_penunjukan')->useCurrent();

            $table->string('jenis_bimbingan', 30);


            // status peserta (karena suatu saat bisa di-nonaktifkan)
            $table->enum('status_peserta', ['aktif', 'nonaktif'])
                ->default('aktif');

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
