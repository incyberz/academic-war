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
            $table->id(); // primary key default numeric
            $table->string('prodi', 10)->unique(); // kode prodi, unik tapi bukan PK
            $table->tinyInteger('urutan')->nullable();

            // FK fakultas (numeric, asumsi tabel fakultas sudah pakai PK id)
            $table->foreignId('fakultas_id')->default(1)->constrained('fakultas');

            $table->string('nama', 30);
            $table->char('jenjang', 2)->nullable();

            $table->timestamps();

            // Index sesuai SQL
            $table->index('jenjang');
            $table->index('fakultas_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
