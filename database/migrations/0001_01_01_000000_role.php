<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id(); // primary key numeric default
            $table->string('role', 20)->unique(); // kode role, unik tapi bukan PK
            $table->string('nama', 50);
            $table->string('deskripsi', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role');
    }
};
