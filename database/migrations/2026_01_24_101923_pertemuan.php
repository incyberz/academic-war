<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertemuan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mk_id')
                ->constrained('mk')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('urutan'); // P1 s.d P14
            $table->string('judul');
            $table->text('materi')->nullable();
            $table->string('tags')->nullable();

            $table->timestamps();

            // constraint
            $table->unique(['mk_id', 'urutan']); // unik per MK
            $table->index(['mk_id', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertemuan');
    }
};
