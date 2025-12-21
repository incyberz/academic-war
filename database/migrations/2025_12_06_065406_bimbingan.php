<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Buat tabel jika belum ada
        if (!Schema::hasTable('bimbingan')) {
            Schema::create('bimbingan', function (Blueprint $table) {
                $table->id(); // PK numeric default

                // FK ke pembimbing
                $table->foreignId('pembimbing_id')
                    ->constrained('pembimbing')
                    ->cascadeOnDelete();

                // FK ke jenis_bimbingan
                $table->foreignId('jenis_bimbingan_id')
                    ->constrained('jenis_bimbingan')
                    ->restrictOnDelete();

                // FK ke tahun_ajar
                $table->foreignId('tahun_ajar_id')
                    ->constrained('tahun_ajar')
                    ->restrictOnDelete();

                $table->string('status', 20)->default('aktif');
                $table->text('catatan')->nullable();

                $table->string('wag')->nullable();
                $table->string('hari_availables')->nullable();
                $table->text('wa_message_template')->nullable();
                $table->string('file_surat_tugas')->nullable();
                $table->string('nomor_surat_tugas')->nullable();
                $table->date('akhir_masa_bimbingan')->nullable();

                $table->timestamps();

                // UNIQUE COMPOSITE
                $table->unique([
                    'pembimbing_id',
                    'jenis_bimbingan_id',
                    'tahun_ajar_id'
                ], 'bimbingan_unique_per_tahun');
            });
        }
    }

    public function down(): void
    {
        Schema::table('bimbingan', function (Blueprint $table) {
            $table->dropForeign(['pembimbing_id']);
            $table->dropForeign(['peserta_bimbingan_id']);
            $table->dropForeign(['jenis_bimbingan_id']);
            $table->dropForeign(['tahun_ajar_id']);
        });

        Schema::dropIfExists('bimbingan');
    }
};
