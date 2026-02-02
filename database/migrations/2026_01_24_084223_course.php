<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course', function (Blueprint $table) {
            $table->id();

            // Identitas course
            $table->string('kode')->unique();
            $table->string('nama');
            $table->text('deskripsi')->nullable();

            // Opsional: konteks stm item (jika course ini dibuat dari konteks stm item tertentu)
            $table->unsignedBigInteger('stm_item_id')->nullable()->index();



            // Tipe course (opsional tapi future-proof)
            // mk      = 1 course = 1 MK (model sekarang)
            // bidang  = course besar / paket kompetensi
            $table->enum('tipe', ['mk', 'bidang'])->default('mk');

            // Metadata
            $table->string('level')->nullable(); // dasar / menengah / lanjutan
            $table->boolean('is_active')->default(true);

            // Audit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course');
    }
};
