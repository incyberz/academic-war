<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trx_panduan', function (Blueprint $table) {
            $table->id();

            // relasi user
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // relasi master panduan
            $table->foreignId('panduan_id')
                ->constrained('panduan')
                ->cascadeOnDelete();

            // waktu user menutup / memahami panduan
            $table->timestamp('dismiss_at')
                ->nullable()
                ->comment('diisi ketika user klik OK / tutup panduan');

            $table->timestamps();

            // satu panduan hanya sekali per user
            $table->unique(['user_id', 'panduan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trx_panduan');
    }
};
