<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id(); // primary key numeric default

            // kode role (mhs, dosen, kaprodi, dll)
            $table->string('role_name', 20)->unique();

            // nama tampil
            $table->string('nama', 50);

            // deskripsi role
            $table->string('deskripsi', 255)->nullable();

            // styling (opsional, untuk badge / card)
            $table->string('color', 50)->nullable();     // contoh: text-white
            $table->string('bg', 50)->nullable();        // contoh: bg-indigo-600
            $table->string('gradient', 100)->nullable(); // contoh: bg-gradient-to-r from-indigo-500 to-indigo-700

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role');
    }
};
