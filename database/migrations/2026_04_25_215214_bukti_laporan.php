<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_laporan', function (Blueprint $table) {
            $table->id();

            // polymorphic relation (bab, sub bab, dll)
            $table->morphs('buktiable');
            // menghasilkan:
            // buktiable_id (BIGINT)
            // buktiable_type (VARCHAR)

            // relasi peserta
            $table->foreignId('peserta_bimbingan_id')
                ->constrained('peserta_bimbingan')
                ->cascadeOnDelete();

            $table->foreignId('parent_id') // untuk revisi bukti, menunjuk ke bukti_laporan_id yang direvisi
                ->nullable()
                ->constrained('bukti_laporan')
                ->nullOnDelete(); // revisi bukti terbaru tidak hilang

            // file
            $table->string('file_path');

            // workflow status (0: pending, 1: approved, 2: rejected)
            $table->tinyInteger('status')->default(0);

            $table->text('catatan')->nullable();

            // gamifikasi
            $table->longText('checklist_ids')->nullable();
            $table->integer('poin_didapat')->default(0);

            // approval
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            // revisi
            $table->unsignedInteger('revisi_ke')->default(0);

            $table->timestamps();

            // index tambahan (optional tapi bagus untuk performa)
            $table->index(['peserta_bimbingan_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_laporan');
    }
};
