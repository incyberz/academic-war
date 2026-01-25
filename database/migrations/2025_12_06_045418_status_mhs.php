<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status_mhs', function (Blueprint $table) {
            $table->id(); // PK auto increment
            $table->string('kode', 20)->unique(); // misal: AKTIF, CUTI, NONAKTIF, LULUS, DROPOUT
            $table->string('nama', 50);          // nama lengkap status
            $table->text('keterangan')->nullable();

            // flag bantuan logic
            $table->boolean('boleh_krs')->default(false);
            $table->boolean('boleh_kuliah')->default(false);
            $table->boolean('boleh_login')->default(true);
            $table->boolean('boleh_bimbingan')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_mhs');
    }
};
