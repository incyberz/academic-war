<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panduan', function (Blueprint $table) {
            $table->id();

            // kode unik panduan (untuk seeder & reference)
            // contoh: DOSEN_BIMBINGAN_INTRO
            $table->string('kode', 100)->unique();

            // target role
            $table->foreignId('role_id')
                ->constrained('role')
                ->cascadeOnDelete();

            // nama route tempat panduan ditampilkan
            // contoh: bimbingan.index
            $table->string('route_name', 100);

            // judul singkat panduan
            $table->string('judul', 150);

            // isi panduan (support HTML / Blade slot)
            $table->text('konten');

            // urutan tampil (jika lebih dari satu panduan di halaman yang sama)
            $table->unsignedSmallInteger('urutan')
                ->default(1);

            // status aktif
            $table->boolean('is_active')
                ->default(true);

            // versi panduan (jika konten diupdate dan ingin reset onboarding)
            $table->unsignedSmallInteger('versi')
                ->default(1);

            $table->timestamps();

            // index untuk query cepat
            $table->index(['role_id', 'route_name', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panduan');
    }
};
