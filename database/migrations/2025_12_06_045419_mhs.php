<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mhs', function (Blueprint $table) {
            $table->id(); // PK numeric default

            // FK ke user
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // FK ke prodi
            $table->foreignId('prodi_id')
                ->nullable()
                ->constrained('prodi')
                ->restrictOnDelete();

            // Data mahasiswa
            $table->string('nama_lengkap');
            $table->string('nim', 20)->nullable()->unique();
            $table->string('angkatan', 4);   // contoh: 2021

            // Status akademik -> FK ke tabel status_mhs
            $table->foreignId('status_mhs_id')
                ->default(1)
                ->constrained('status_mhs')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mhs');
    }
};
