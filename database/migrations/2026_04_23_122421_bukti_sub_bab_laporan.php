<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_sub_bab_laporan', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELASI UTAMA
            |--------------------------------------------------------------------------
            */
            $table->foreignId('sub_bab_laporan_id')
                ->constrained('sub_bab_laporan')
                ->cascadeOnDelete();

            $table->foreignId('peserta_bimbingan_id')
                ->constrained('peserta_bimbingan')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | FILE BUKTI (JPG)
            |--------------------------------------------------------------------------
            */
            $table->string('file_path');

            /*
            |--------------------------------------------------------------------------
            | WORKFLOW (tinyint status)
            | 0 = pending
            | 1 = revisi
            | 2 = approved
            |--------------------------------------------------------------------------
            */
            $table->tinyInteger('status')->default(0);

            $table->text('catatan')->nullable();

            /*
            |--------------------------------------------------------------------------
            | GAMIFIKASI
            |--------------------------------------------------------------------------
            */
            $table->integer('poin_didapat')->default(0);

            /*
            |--------------------------------------------------------------------------
            | APPROVAL
            |--------------------------------------------------------------------------
            */
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | REVISI TRACKING
            |--------------------------------------------------------------------------
            */
            $table->integer('revisi_ke')->default(0);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEXES (penting untuk leaderboard & dashboard)
            |--------------------------------------------------------------------------
            */
            $table->index(['peserta_bimbingan_id', 'status']);
            $table->index(['sub_bab_laporan_id']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_sub_bab_laporan');
    }
};
