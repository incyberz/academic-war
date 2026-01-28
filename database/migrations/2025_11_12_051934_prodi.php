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

            $table->foreignId('fakultas_id')->constrained('fakultas')->nullable(); // untuk kampus kecil nullable
            $table->foreignId('jenjang_id')->constrained('jenjang');

            $table->string('nama', 30);

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
