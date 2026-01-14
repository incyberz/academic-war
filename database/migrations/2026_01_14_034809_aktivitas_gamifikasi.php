<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aktivitas_gamifikasi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->string('tipe_aktivitas', 100);

            $table->string('source_table', 100);
            $table->unsignedBigInteger('source_id');

            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->timestamps();

            // index
            $table->index('user_id');
            $table->index('tipe_aktivitas');
            $table->index(['source_table', 'source_id']);

            // foreign key (opsional)
            // $table->foreign('user_id')
            //       ->references('id')
            //       ->on('users')
            //       ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aktivitas_gamifikasi');
    }
};
