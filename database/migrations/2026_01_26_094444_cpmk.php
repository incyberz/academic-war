<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cpmk', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 20)->nullable();
            // contoh: CPMK-1, CPMK-2 (opsional tapi rapi)

            $table->text('deskripsi');

            // relasi ke CPL
            $table->foreignId('cpl_id')
                ->constrained('cpl')
                ->cascadeOnDelete();

            // relasi ke MK
            $table->foreignId('mk_id')
                ->constrained('mk')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cpmk');
    }
};
