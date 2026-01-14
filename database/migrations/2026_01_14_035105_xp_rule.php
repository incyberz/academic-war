
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('xp_rule', function (Blueprint $table) {
            $table->id();

            $table->string('tipe_aktivitas', 100);
            $table->integer('xp_dasar');

            $table->json('kondisi')->nullable();

            $table->date('berlaku_dari')->nullable();
            $table->date('berlaku_sampai')->nullable();

            $table->boolean('aktif')->default(true);

            $table->timestamps();

            // index
            $table->index('tipe_aktivitas');
            $table->index('aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('xp_rule');
    }
};
