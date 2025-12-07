<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('role', function (Blueprint $t) {
            // PK berupa string
            $t->string('role', 20)->primary();

            $t->string('nama', 50);
            $t->string('deskripsi', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role');
    }
};
