<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {



        Schema::create('challenge_level_submission', function (Blueprint $table) {
            $table->id();

            // relasi utama
            $table->foreignId('challenge_submission_id')
                ->constrained('challenge_submission')
                ->cascadeOnDelete();

            $table->foreignId('challenge_level_id')
                ->constrained('challenge_level')
                ->cascadeOnDelete();

            // bukti yang diupload mhs (link / path)
            $table->string('bukti')->nullable();

            // catatan mhs untuk level ini
            $table->text('catatan')->nullable();

            // approval per level (opsional, kalau dosen mau granular)
            $table->boolean('is_approved')->nullable();
            $table->text('feedback')->nullable();

            $table->timestamps();

            // satu submission tidak boleh submit level yang sama dua kali
            // $table->unique([
            //     'challenge_submission_id',
            //     'challenge_level_id'
            // ]);

            $table->unique(
                ['challenge_submission_id', 'challenge_level_id'],
                'chal_submis_lv_unique' // nama index pendek
            );


            $table->index('challenge_submission_id');
            $table->index('challenge_level_id');
        });



        //         DB::statement("
        //     ALTER TABLE challenge_level_submission 
        //     ADD CONSTRAINT cls_cs_lvl_unique UNIQUE (challenge_submission_id, challenge_level_id)
        // ");
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_level_submission');
    }
};
