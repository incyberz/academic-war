<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Buat tabel jika belum ada
        if (!Schema::hasTable('bimbingan')) {
            Schema::create('bimbingan', function (Blueprint $t) {
                $t->id();

                $t->foreignId('pembimbing_id')
                    ->constrained('pembimbing')
                    ->cascadeOnDelete();

                $t->foreignId('peserta_bimbingan_id')
                    ->constrained('peserta_bimbingan')
                    ->cascadeOnDelete();

                $t->string('jenis_bimbingan', 20);
                $t->smallInteger('tahun_ajar')->unsigned();

                $t->string('status', 20)->default('aktif');
                $t->text('catatan')->nullable();

                $t->timestamps();
            });
        }

        // Tambahkan foreign key dengan try-catch agar aman jika sudah ada
        Schema::table('bimbingan', function (Blueprint $t) {
            try {
                if (Schema::hasColumn('bimbingan', 'jenis_bimbingan')) {
                    $t->foreign('jenis_bimbingan')
                        ->references('jenis_bimbingan')->on('jenis_bimbingan')
                        ->restrictOnDelete();
                }
            } catch (\Throwable $e) {
                // FK sudah ada → diamkan (auto resume)
            }

            try {
                if (Schema::hasColumn('bimbingan', 'tahun_ajar')) {
                    $t->foreign('tahun_ajar')
                        ->references('tahun_ajar')->on('tahun_ajar')
                        ->restrictOnDelete();
                }
            } catch (\Throwable $e) {
                // FK sudah ada → diamkan
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('bimbingan')) {
            // drop FK dengan try-catch agar aman walau tidak ada
            Schema::table('bimbingan', function (Blueprint $t) {
                try {
                    $t->dropForeign(['jenis_bimbingan']);
                } catch (\Throwable $e) {
                }
                try {
                    $t->dropForeign(['tahun_ajar']);
                } catch (\Throwable $e) {
                }
            });

            Schema::dropIfExists('bimbingan');
        }
    }
};
