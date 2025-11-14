<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prodi', function (Blueprint $t) {
            $t->id();
            $t->foreignId('fakultas_id')
                ->constrained('fakultas')
                ->restrictOnDelete(); // ON DELETE RESTRICT
            $t->string('nama');
            $t->string('kode')->unique();
            $t->string('jenjang'); // S1, D3, S2, dll
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
