<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Skip jika tabel sudah ada
        if (Schema::hasTable('dosen')) {
            return;
        }

        Schema::create('dosen', function (Blueprint $table) {
            $table->id(); // primary key bigint unsigned

            $table->string('nama', 50);

            // FK ke users (numeric)
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // FK ke prodi (numeric)
            $table->foreignId('prodi_id')
                ->nullable()
                ->constrained('prodi')
                ->restrictOnDelete();

            $table->char('nidn', 16)->nullable();
            $table->string('gelar_depan', 10)->nullable();
            $table->string('gelar_belakang', 30)->nullable();
            $table->string('jabatan_fungsional', 10)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
