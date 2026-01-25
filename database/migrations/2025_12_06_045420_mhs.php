<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mhs', function (Blueprint $table) {
            $table->id();

            // relasi inti
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('prodi_id')
                ->nullable()
                ->constrained('prodi')
                ->restrictOnDelete();

            $table->foreignId('shift_id')
                ->nullable()
                ->constrained('shift')
                ->restrictOnDelete();

            // $table->foreignId('jalur_masuk_id')
            //     ->nullable()
            //     ->constrained('jalur_masuk')
            //     ->restrictOnDelete();

            // $table->foreignId('kampus_id')
            //     ->nullable()
            //     ->constrained('kampus')
            //     ->restrictOnDelete();

            $table->integer('kampus_id')->nullable(); // ondev
            $table->integer('jalur_masuk_id')->nullable(); // ondev
            $table->integer('pmb_id')->nullable(); // ondev



            // identitas akademik
            $table->string('nama_lengkap', 100); // sesuai KTP / ijazah
            $table->string('nim', 20)->nullable()->unique();
            $table->string('angkatan', 4);       // contoh: 2021
            $table->tinyInteger('semester_awal')->default(1);

            $table->string('email_kampus')->nullable();

            // status global mhs (lifetime)
            $table->foreignId('status_mhs_id')
                ->nullable()
                ->constrained('status_mhs')
                ->restrictOnDelete();
            // contoh: AKTIF, LULUS, DO, NONAKTIF

            // metadata penting
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_lulus')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mhs');
    }
};
