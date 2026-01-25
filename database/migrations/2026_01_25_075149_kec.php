<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kec', function (Blueprint $table) {
            $table->char('id', 6)->primary(); // ID kecamatan, char(6)
            $table->string('nama_kec', 30);   // Nama kecamatan
            $table->string('nama_kab', 30);   // Nama kabupaten
            $table->boolean('is_baru')->nullable();
            $table->timestamps();             // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kec');
    }
};
