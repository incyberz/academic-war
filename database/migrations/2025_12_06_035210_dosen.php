<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->bigIncrements('id'); // bigint unsigned + AI

            $table->string('nama', 50);
            $table->foreignId('user_id')->constrained('users'); // bigint unsigned + FK
            $table->foreignId('prodi_id')->nullable()->constrained('prodi'); // FK nullable

            $table->char('nidn', 16)->nullable();
            $table->string('gelar_depan', 10)->nullable();
            $table->string('gelar_belakang', 30)->nullable();
            $table->string('jabatan_fungsional', 10)->nullable();

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
