<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi_bimbingan', function (Blueprint $table) {
            $table->id();

            // Relasi ke peserta bimbingan & sesi
            $table->foreignId('peserta_bimbingan_id')
                ->constrained('peserta_bimbingan')
                ->cascadeOnDelete();

            $table->foreignId('sesi_bimbingan_id')
                ->nullable()
                ->constrained('sesi_bimbingan')
                ->nullOnDelete();

            // Channel: whatsapp, email, push, in-app
            $table->enum('channel', ['whatsapp', 'email', 'push', 'in-app'])->default('whatsapp');

            // Status bimbingan
            $table->tinyInteger('status_terakhir_bimbingan')->nullable()
                ->comment('1=ontime, -1=telat, -2=kritis');

            $table->tinyInteger('status_sesi_bimbingan')->nullable()
                ->comment('-100, -1, 0, 1, 2, 3, 100');

            // Pesan tambahan opsional
            $table->text('pesan_tambahan')->nullable();

            // Logging pengirim
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi_bimbingan');
    }
};
