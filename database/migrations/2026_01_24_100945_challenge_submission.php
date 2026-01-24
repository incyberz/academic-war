<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenge_submission', function (Blueprint $table) {
            $table->id();

            // relasi inti
            $table->foreignId('challenge_id')
                ->constrained('challenge')
                ->cascadeOnDelete();

            $table->foreignId('mhs_id')
                ->constrained('mhs')
                ->cascadeOnDelete();

            // status proses penilaian
            $table->enum('status', [
                'draft',      // belum final submit
                'submitted',  // sudah dikirim mhs
                'approved',   // disetujui dosen
                'rejected',   // ditolak (revisi)
            ])->default('draft');

            // apresiasi tambahan dari dosen
            $table->unsignedInteger('apresiasi_xp')->default(0);

            // feedback dosen
            $table->text('feedback')->nullable();

            // waktu penting
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // constraint penting
            $table->unique(['challenge_id', 'mhs_id']);
            $table->index(['challenge_id', 'status']);
            $table->index('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_submission');
    }
};
