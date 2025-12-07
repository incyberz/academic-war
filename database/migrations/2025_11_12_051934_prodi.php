<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Skip jika tabel sudah ada
        if (Schema::hasTable('prodi')) {
            return;
        }

        Schema::create('prodi', function (Blueprint $table) {
            $table->string('prodi', 10)->primary();
            $table->tinyInteger('urutan')->nullable();

            $table->string('fakultas', 10)->default('fkom');
            $table->string('nama', 30);
            $table->char('jenjang', 2)->nullable();

            $table->timestamps();

            // Index sesuai SQL
            $table->index('jenjang');
            $table->index('fakultas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
