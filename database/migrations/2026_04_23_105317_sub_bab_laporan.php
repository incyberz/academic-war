<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_bab_laporan', function (Blueprint $table) {
            $table->id();

            // relasi
            $table->foreignId('bab_laporan_id')
                ->constrained('bab_laporan')
                ->cascadeOnDelete();

            // identitas
            $table->string('kode', 20);
            $table->string('nama');
            $table->integer('urutan'); // ❗ WAJIB (tanpa default)
            $table->text('deskripsi')->nullable();

            // gamifikasi
            $table->integer('poin')->default(0);
            $table->boolean('is_wajib')->default(true);

            // bukti (JPG only)
            $table->text('petunjuk_bukti')->nullable();
            $table->string('contoh_bukti')->nullable();

            // workflow
            $table->boolean('can_revisi')->default(true);

            // kontrol
            $table->boolean('is_active')->default(true);
            $table->boolean('is_locked')->default(false);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Constraint
            |--------------------------------------------------------------------------
            */

            // kode unik dalam 1 bab
            $table->unique(['bab_laporan_id', 'kode']);

            // ❗ urutan unik dalam 1 bab (ini yang krusial)
            // $table->unique(['bab_laporan_id', 'urutan']);

            // index performa
            $table->index(['bab_laporan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_bab_laporan');
    }
};
