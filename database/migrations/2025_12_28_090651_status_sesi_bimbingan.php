<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('status_sesi_bimbingan', function (Blueprint $table) {
            $table->integer('id')->primary(); // manual ID (-2 s/d 4)
            $table->string('nama_status', 100);
            $table->text('keterangan');
            $table->string('bg')->default('info'); // info | warning | danger | success
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_sesi_bimbingan');
    }
};
