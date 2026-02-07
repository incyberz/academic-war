<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();

            // =========================
            // KONTEKS AKADEMIK
            // =========================
            $table->foreignId('stm_item_id')
                ->constrained('stm_item')
                ->cascadeOnDelete();

            // hari eksplisit
            $table->unsignedTinyInteger('weekday'); // 1=Senin ... 6=Sabtu

            // helper input saat charter
            $table->foreignId('jam_sesi_id')
                ->constrained('jam_sesi')
                ->restrictOnDelete();

            // ruang fisik / online
            $table->foreignId('ruang_id')
                ->nullable()
                ->constrained('ruang')
                ->restrictOnDelete();

            // JAM AKTUAL (yang dipakai sistem & UI)
            $table->time('jam_awal');
            $table->time('jam_akhir');

            // status
            $table->boolean('is_locked')->default(false);
            $table->unsignedTinyInteger('sks_jadwal')->nullable();


            // audit
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // =========================
            // CONSTRAINTS
            // =========================
            $table->unique('stm_item_id');


            // =========================
            // INDEXES
            // =========================
            $table->index('weekday');
            $table->index('ruang_id');
            $table->index('jam_awal');
            $table->index('jam_akhir');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
