<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertemuan_ta', function (Blueprint $table) {
            $table->id();

            // Relasi ke MK di TA
            $table->foreignId('mk_ta_id')->constrained('mk_ta')->cascadeOnDelete();

            // Relasi ke master pertemuan
            $table->foreignId('pertemuan_id')->constrained('pertemuan')->cascadeOnDelete();

            // Topik / catatan opsional
            $table->string('topik')->nullable();
            $table->text('catatan')->nullable();

            // Tags string: a-z0-9 only, dipisahkan koma
            $table->string('tags')->nullable();

            $table->timestamps();

            // Unik per MK_TA + pertemuan master
            $table->unique(['mk_ta_id', 'pertemuan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertemuan_ta');
    }
};
