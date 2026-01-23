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
        Schema::create('status_akademik', function (Blueprint $table) {
            $table->id(); // PK auto increment
            $table->string('kode', 20)->unique(); // misal: AKTIF, CUTI, NONAKTIF, LULUS, DROPOUT
            $table->string('nama', 50);          // nama lengkap status
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_akademik');
    }
};
