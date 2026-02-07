<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('ruang', function (Blueprint $table) {
      $table->id();

      $table->string('kode')->unique();       // Kode ruang resmi
      $table->string('nama')->unique();       // Nama display ruang
      $table->unsignedInteger('kapasitas');

      $table->string('jenis_ruang')->default('kelas'); // config jenis_ruang

      $table->boolean('is_ready')->default(true);

      $table->string('gedung')->nullable();
      $table->string('blok')->nullable();
      $table->tinyInteger('lantai')->default(1);

      $table->timestamps();

      $table->index(['kode', 'nama']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ruang');
  }
};
