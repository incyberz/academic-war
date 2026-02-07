<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jam_sesi', function (Blueprint $table) {
            $table->id();

            // relasi ke shift
            $table->foreignId('shift_id')
                ->constrained('shift')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('weekday'); // 1=Senin ... 7=Minggu
            $table->unsignedTinyInteger('urutan');  // urutan sesi dalam satu shift & hari

            $table->time('jam_mulai');
            $table->time('jam_selesai');

            // true  = boleh di-charter
            // false = default sistem, tidak bisa diambil
            $table->boolean('can_chartered')->default(false);

            $table->string('keterangan')->nullable();
            $table->timestamps();

            // unik per shift + hari + urutan
            $table->unique(['shift_id', 'weekday', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_sesi');
    }
};

// php artisan migrate --path=database/migrations/202x_xx_xx_xxxxxx_create_jam_sesi_table.php
