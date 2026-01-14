<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('xp_trx', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('aktivitas_gamifikasi_id');

            $table->integer('xp'); // nilai XP
            $table->enum('arah', ['+', '-']); // debit / kredit XP

            $table->integer('saldo_setelah'); // saldo XP setelah transaksi

            $table->string('keterangan')->nullable();

            $table->timestamps();

            // index
            $table->index('user_id');
            $table->index('aktivitas_gamifikasi_id');

            // pastikan 1 aktivitas hanya menghasilkan 1 trx XP
            $table->unique(
                ['user_id', 'aktivitas_gamifikasi_id'],
                'uniq_user_aktivitas_xp'
            );

            // foreign key (opsional, direkomendasikan)
            // $table->foreign('aktivitas_gamifikasi_id')
            //       ->references('id')
            //       ->on('aktivitas_gamifikasi')
            //       ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('xp_trx');
    }
};
