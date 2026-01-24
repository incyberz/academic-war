<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas_mhs', function (Blueprint $table) {
            $table->id();

            // relasi utama
            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            $table->foreignId('mhs_id')
                ->constrained('mhs')
                ->cascadeOnDelete();

            // status keikutsertaan mahasiswa di kelas
            $table->enum('status', [
                'aktif',
                'cuti',
                'mengulang',
                'drop',
            ])->default('aktif');

            // informasi tambahan
            $table->text('keterangan')->nullable();

            $table->enum('jabatan', [
                'ketua',
                'wakil',
                'sekretaris'
            ])->nullable();

            $table->boolean('can_approve')->default(false);


            $table->timestamps();

            // satu mhs hanya boleh terdaftar sekali di kelas yang sama
            $table->unique(['kelas_id', 'mhs_id']);

            $table->index(['kelas_id']);
            $table->index(['mhs_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_mhs');
    }
};
