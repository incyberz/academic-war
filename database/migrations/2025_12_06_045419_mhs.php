<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mhs', function (Blueprint $t) {
            $t->id();

            // FK ke user
            $t->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // FK ke prodi (nullable)
            $t->foreignId('prodi_id')
                ->nullable()
                ->constrained('prodi')
                ->nullOnDelete();

            // Data mahasiswa
            $t->string('nama');
            $t->string('nim', 20)->nullable()->unique();
            $t->string('angkatan', 4);   // contoh: 2021

            // Status akademik
            $t->enum('status', [
                'aktif',
                'cuti',
                'nonaktif',
                'lulus',
                'dropout'
            ])->default('aktif');

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mhs');
    }
};
