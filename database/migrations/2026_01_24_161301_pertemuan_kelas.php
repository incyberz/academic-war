<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertemuan_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pertemuan_ta_id')->constrained('pertemuan_ta')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->text('catatan_dosen')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->unique(['pertemuan_ta_id', 'kelas_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertemuan_kelas');
    }
};
