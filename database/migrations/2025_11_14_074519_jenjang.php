<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenjang', function (Blueprint $table) {
            $table->char('jenjang', 2)->primary();        // PK: D3, S1, S2, S3
            $table->string('nama', 30);                   // Nama jenjang
            $table->tinyInteger('jumlah_semester');       // Semester normal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenjang');
    }
};
