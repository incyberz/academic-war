<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembimbing', function (Blueprint $t) {
            $t->id();

            // FK ke dosen
            $t->foreignId('dosen_id')
                ->constrained('dosen')
                ->restrictOnDelete();

            // Surat Tugas
            $t->string('nomor_surat')->nullable(); // nomor surat tugas
            $t->string('file_surat')->nullable();  // path file surat tugas
            $t->date('tanggal_surat')->nullable();

            // Keterangan tambahan
            $t->text('catatan')->nullable();

            // Apakah pembimbing masih aktif?
            $t->boolean('is_active')->default(true);

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembimbing');
    }
};
