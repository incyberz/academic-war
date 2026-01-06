<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sesi_bimbingan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peserta_bimbingan_id')
                ->constrained('peserta_bimbingan')
                ->cascadeOnDelete();

            $table->foreignId('bab_laporan_id')
                ->default(1)
                ->constrained('bab_laporan')
                ->cascadeOnDelete();

            $table->foreignId('tahapan_bimbingan_id') // diisi oleh sistem atau pembimbing
                ->nullable()
                ->constrained('tahapan_bimbingan')
                ->cascadeOnDelete();

            $table->tinyInteger('status_sesi_bimbingan')->default(0);
            // -2 : ditolak
            // -1 : revisi
            //  0 : diajukan
            //  1 : diproses
            //  2 : disetujui
            //  3 : selesai
            //  4 : final

            $table->string('topik', 50)->nullable();

            $table->text('pesan_mhs')->nullable();
            $table->text('pesan_dosen')->nullable();
            $table->text('nama_dokumen')->nullable();


            $table->boolean('is_offline')->default(false); // online/offline
            $table->date('tanggal_offline')->nullable();
            $table->time('jam_offline')->nullable();
            $table->string('lokasi_offline', 255)->nullable();

            $table->string('file_bimbingan', 200)->nullable();
            $table->string('file_review', 200)->nullable();

            $table->timestamp('tanggal_pengajuan')->nullable();
            $table->timestamp('tanggal_download')->nullable();
            $table->timestamp('tanggal_review')->nullable();
            $table->timestamp('tanggal_revisi')->nullable();

            $table->boolean('is_locked')->default(false);

            $table->unsignedBigInteger('revisi_id')->nullable();
            $table->unsignedSmallInteger('revisi_ke')->default(0);

            $table->tinyInteger('nilai_dosen')->nullable();

            $table->integer('xp_didapat')->default(0);

            $table->string('ip_pengajuan', 45)->nullable();

            $table->timestamp('last_reminder_at')->nullable();
            $table->tinyInteger('reminder_count')->nullable();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_bimbingan');
    }
};
