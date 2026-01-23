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

            // Data mhs.
            $table->string('nama_lengkap');
            $table->string('nim', 20)->nullable()->unique();
            $table->string('angkatan', 4);   // contoh: 2021

            // Status akademik -> FK ke tabel status_akademik
            $table->foreignId('status_akademik_id')
                ->default(1)
                ->constrained('status_akademik')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mhs');
    }
};
