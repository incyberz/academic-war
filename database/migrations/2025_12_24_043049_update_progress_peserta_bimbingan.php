<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('peserta_bimbingan')->where('id', 1)->update([
            'progress' => 87,
            'terakhir_topik' => 'bab 3 metodologi',
            'terakhir_bimbingan' => '2025-12-20 07:45:29',
            'terakhir_reviewed' => '2025-12-20 23:45:36',
        ]);

        DB::table('peserta_bimbingan')->where('id', 2)->update([
            'progress' => 12,
            'terakhir_topik' => 'judul PKL',
            'terakhir_bimbingan' => '2025-12-01 04:27:33',
            'terakhir_reviewed' => '2025-12-11 03:27:45',
        ]);

        DB::table('peserta_bimbingan')->where('id', 3)->update([
            'progress' => 23,
            'terakhir_topik' => 'bab 1 pkl',
            'terakhir_bimbingan' => '2025-12-11 01:16:49',
            'terakhir_reviewed' => '2025-12-11 01:28:49',
        ]);

        DB::table('peserta_bimbingan')->where('id', 4)->update([
            'progress' => 32,
            'terakhir_topik' => 'bab 1 rumusan',
            'terakhir_bimbingan' => '2025-11-03 09:56:14',
            'terakhir_reviewed' => '2025-12-10 09:56:14',
        ]);
    }

    public function down(): void
    {
        // Tidak di-rollback karena ini data update spesifik
        // Bisa diisi reset NULL jika diperlukan
    }
};
