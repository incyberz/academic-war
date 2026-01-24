<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quest_submission', function (Blueprint $table) {
            $table->id();

            // relasi inti
            $table->foreignId('quest_id')
                ->constrained('quest')
                ->cascadeOnDelete();

            $table->foreignId('mhs_id')
                ->constrained('mhs')
                ->cascadeOnDelete();

            // bukti pengerjaan (file / link)
            $table->string('bukti')->nullable();

            // catatan dari mahasiswa
            $table->text('catatan')->nullable();

            // status penilaian
            $table->enum('status', [
                'draft',
                'submitted',
                'approved',
                'rejected',
            ])->default('draft');

            // apresiasi tambahan dari dosen
            $table->unsignedInteger('apresiasi_xp')->default(0);

            // feedback dosen
            $table->text('feedback')->nullable();

            // waktu penting
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // 1 mhs hanya boleh submit 1x per quest
            $table->unique(['quest_id', 'mhs_id']);

            $table->index(['quest_id', 'status']);
            $table->index('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_submission');
    }
};
