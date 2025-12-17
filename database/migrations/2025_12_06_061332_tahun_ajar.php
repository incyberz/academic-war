<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tahun_ajar', function (Blueprint $table) {
            $table->id(); // PK numeric default

            // kode tahun ajar, misal 20251 (TA 2025/1)
            $table->smallInteger('kode')->unique();

            // Status apakah tahun ajar sedang aktif
            $table->boolean('aktif')->default(false);

            // Range periode (opsional)
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_ajar');
    }
};
