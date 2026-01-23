<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jabatan_struktural', function (Blueprint $table) {
            $table->id();

            // relasi utama
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('prodi_id')
                ->constrained('prodi')
                ->cascadeOnDelete();

            // jenis jabatan
            $table->string('jabatan');
            // contoh: kaprodi, sekprodi, koor_lab, gkm, dll

            // asal SDM
            $table->enum('asal_sdm', ['dosen', 'tendik'])
                ->comment('Asal SDM pemangku jabatan');

            // status PLT
            $table->boolean('plt')->default(false);

            // hak / kewenangan (penting untuk sistem)
            $table->boolean('boleh_acc_krs')->default(false);
            $table->boolean('boleh_acc_cuti')->default(false);
            $table->boolean('boleh_bimbingan')->default(false);
            $table->boolean('boleh_ubah_kurikulum')->default(false);

            // periode jabatan
            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();

            $table->boolean('aktif')->default(true);

            $table->timestamps();

            // mencegah dobel jabatan aktif di prodi yang sama
            $table->unique(
                ['user_id', 'prodi_id', 'jabatan', 'aktif'],
                'unique_jabatan_struktural_aktif'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan_struktural');
    }
};
