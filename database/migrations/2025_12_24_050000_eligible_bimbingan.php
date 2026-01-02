<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eligible_bimbingan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tahun_ajar_id');
            $table->unsignedBigInteger('jenis_bimbingan_id');
            $table->unsignedBigInteger('mhs_id');
            $table->unsignedBigInteger('assign_by');

            $table->timestamps();

            $table->unique(
                ['tahun_ajar_id', 'jenis_bimbingan_id', 'mhs_id'],
                'eligible_unique'
            );

            $table->foreign('tahun_ajar_id')->references('id')->on('tahun_ajar');
            $table->foreign('jenis_bimbingan_id')->references('id')->on('jenis_bimbingan');
            $table->foreign('mhs_id')->references('id')->on('mhs');
            $table->foreign('assign_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eligible_bimbingan');
    }
};
