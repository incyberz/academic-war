<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mhs_ta', function (Blueprint $table) {
            $table->id();

            // relasi utama
            $table->foreignId('mhs_id')
                ->constrained('mhs')
                ->cascadeOnDelete();

            $table->foreignId('tahun_ajar_id')
                ->constrained('tahun_ajar')
                ->cascadeOnDelete();

            $table->foreignId('status_mhs_id')
                ->constrained('status_mhs');

            // metadata opsional (siap histori)
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->timestamps();

            // satu mahasiswa hanya boleh satu status per tahun ajar
            $table->unique(['mhs_id', 'tahun_ajar_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mhs_ta');
    }
};
