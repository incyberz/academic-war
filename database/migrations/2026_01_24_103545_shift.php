<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift', function (Blueprint $table) {
            $table->id();

            // identitas shift
            $table->string('kode', 10)->unique(); // R, NR, P, S, dll
            $table->string('nama');               // Reguler, Non-Reguler, Pagi, Sore

            // jam operasional default
            $table->time('jam_awal_kuliah')->default('08:00');
            $table->time('jam_akhir_kuliah')->default('16:00');

            // aturan akademik
            $table->unsignedTinyInteger('min_persen_presensi')->default(75); // %
            $table->unsignedTinyInteger('min_pembayaran')->default(50);      // %

            // keterangan tambahan
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // index bantu
            $table->index('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift');
    }
};
