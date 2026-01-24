<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('challenge', function (Blueprint $table) {
            $table->id();

            // Relasi struktur konten
            $table->foreignId('unit_id')
                ->constrained('unit')
                ->cascadeOnDelete();

            // Identitas challenge
            $table->string('kode')->nullable(); // contoh: CHL-01
            $table->string('judul');
            $table->text('instruksi')->nullable(); // instruksi pengerjaan

            // Panduan & pengumpulan
            $table->string('link_panduan')->nullable(); // docs / video / repo
            $table->string('cara_pengumpulan')->nullable(); // upload, repo, presentasi, dll

            // Gamifikasi
            $table->unsignedTinyInteger('level'); // 1–5 (config-based)
            $table->unsignedInteger('xp')->nullable(); // override XP dasar

            // Ontime system (override opsional)
            $table->unsignedInteger('ontime_xp')->nullable();
            $table->unsignedInteger('ontime_at')->nullable();       // menit
            $table->unsignedInteger('ontime_deadline')->nullable(); // menit

            // Kontrol
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('urutan')->nullable();

            $table->timestamps();

            // Index
            $table->index('unit_id');
            $table->index('level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge');
    }
};
