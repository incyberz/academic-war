<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username', 20)->unique();

            $table->string('whatsapp', 15)->nullable();
            $table->timestamp('whatsapp_verified_at')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('image')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->enum('status', [1, -1])->default(1);

            // relasi ke fakultas (nullable)
            $table->string('fakultas', 10)->nullable();
            $table->foreign('fakultas')->references('fakultas')->on('fakultas')->restrictOnDelete();

            $table->string('prodi', 10)->nullable();
            $table->foreign('prodi')->references('prodi')->on('prodi')->restrictOnDelete();

            // jabatan admin
            $table->string('jabatan', 50)->nullable();

            // field khusus admin
            $table->string('nidn', 20)->nullable(); // kalau admin kampus kadang dosen juga
            $table->string('nik', 20)->nullable();  // opsional
            $table->text('catatan')->nullable();
            $table->date('awal_bertugas')->default(DB::raw('CURRENT_DATE'));


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
