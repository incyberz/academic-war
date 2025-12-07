<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tahun_ajar', function (Blueprint $t) {

            // PRIMARY KEY: tahun_ajar (smallint 5 digit)
            $t->smallInteger('tahun_ajar')->unsigned();
            $t->primary('tahun_ajar');

            // Status apakah tahun ajar sedang aktif
            $t->boolean('aktif')->default(false);

            // Range periode (opsional)
            $t->date('tanggal_mulai')->nullable();
            $t->date('tanggal_selesai')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_ajar');
    }
};
