<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bimbingan', function (Blueprint $t) {
            $t->id();

            // FK ke pembimbing
            $t->foreignId('pembimbing_id')
                ->constrained('pembimbing')
                ->cascadeOnDelete();

            // FK ke peserta bimbingan
            $t->foreignId('peserta_bimbingan_id')
                ->constrained('peserta_bimbingan')
                ->cascadeOnDelete();

            // FK ke jenis_bimbingan (PK berupa string: pkl, skripsi, kkn)
            $t->string('jenis_bimbingan', 20);
            $t->foreign('jenis_bimbingan')
                ->references('jenis_bimbingan')->on('jenis_bimbingan')
                ->restrictOnDelete();

            // FK ke tahun ajar (smallint PK)
            $t->smallInteger('tahun_ajar')->unsigned();
            $t->foreign('tahun_ajar')
                ->references('tahun_ajar')->on('tahun_ajar')
                ->restrictOnDelete();

            // Status bimbingan
            // contoh: 'aktif', 'selesai', 'dibatalkan'
            $t->string('status', 20)->default('aktif');

            // Keterangan umum (optional)
            $t->text('catatan')->nullable();

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingan');
    }
};
