<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();

            // 🔗 polymorphic relation (Bab / SubBab / lainnya)
            $table->morphs('checklistable');
            // checklistable_id (BIGINT)
            // checklistable_type (VARCHAR)

            // 🧠 isi checklist
            $table->text('pertanyaan');

            // 🔢 urutan tampil
            $table->unsignedInteger('urutan')->default(1);

            // 🎮 gamifikasi
            $table->unsignedInteger('poin')->default(10);

            // 🧱 kontrol wajib vs challenge
            $table->boolean('is_wajib')->default(true);

            // 🔛 kontrol aktif/nonaktif
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // ⚡ index untuk performa query
            $table->index(
                ['checklistable_type', 'checklistable_id', 'urutan'],
                'checklist_lookup_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};
