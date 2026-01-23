<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('status_akademik', function (Blueprint $table) {
            $table->id();

            // kode internal (AMAN untuk logic & integrasi)
            $table->string('kode', 20)->unique();
            // contoh: AKTIF, CUTI, LULUS, DO, NONAKTIF

            // nama tampilan
            $table->string('nama', 50);
            // contoh: Aktif, Cuti, Lulus

            // penjelasan akademik
            $table->text('keterangan')->nullable();

            // flag bantuan logic
            $table->boolean('boleh_krs')->default(false);
            $table->boolean('boleh_kuliah')->default(false);
            $table->boolean('boleh_bimbingan')->default(false);
            $table->boolean('boleh_login')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_akademik');
    }
};
