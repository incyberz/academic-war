<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $t) {
            $t->id();
            $t->string('nama', 50);
            $t->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete(); // tidak nullable, dosen wajib punya user_id
            $t->foreignId('prodi_id')
                ->nullable()
                ->constrained('prodi')
                ->restrictOnDelete();
            $t->char('nidn', 16)->unique()->nullable();
            $t->string('gelar_depan', 10)->nullable();
            $t->string('gelar_belakang', 30)->nullable();
            $t->string('jabatan_fungsional', 10)->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
