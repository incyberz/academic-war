<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_kelas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stm_item_id')
                ->constrained('stm_item')
                ->cascadeOnDelete();

            $table->foreignId('unit_id')
                ->constrained('unit')
                ->restrictOnDelete(); // atau cascadeOnDelete jika Anda yakin

            $table->date('tanggal_rencana')->nullable();

            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->text('catatan_dosen')->nullable();

            $table->unsignedTinyInteger('status')->default(0);
            $table->string('fase', 20)->nullable();
            $table->string('label', 20)->nullable();

            $table->timestamps();

            $table->unique(['stm_item_id', 'unit_id']);

            $table->index(['stm_item_id', 'status']);
            $table->index(['stm_item_id', 'tanggal_rencana']);
            $table->index(['stm_item_id', 'unit_id']);
            $table->index(['start_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_kelas');
    }
};
