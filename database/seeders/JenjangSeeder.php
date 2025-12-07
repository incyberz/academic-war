<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenjangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenjang')->updateOrInsert(
            ['jenjang' => 'D1'],
            ['nama' => 'Diploma 1', 'jumlah_semester' => 2]
        );

        DB::table('jenjang')->updateOrInsert(
            ['jenjang' => 'D2'],
            ['nama' => 'Diploma 2', 'jumlah_semester' => 4]
        );

        DB::table('jenjang')->updateOrInsert(
            ['jenjang' => 'D3'],
            ['nama' => 'Diploma 3', 'jumlah_semester' => 6]
        );

        DB::table('jenjang')->updateOrInsert(
            ['jenjang' => 'D4'],
            ['nama' => 'Diploma 4 / Sarjana Terapan', 'jumlah_semester' => 8]
        );

        DB::table('jenjang')->updateOrInsert(
            ['jenjang' => 'S1'],
            ['nama' => 'Sarjana', 'jumlah_semester' => 8]
        );

        DB::table('jenjang')->updateOrInsert(
            ['jenjang' => 'S2'],
            ['nama' => 'Magister', 'jumlah_semester' => 4]
        );

        DB::table('jenjang')->updateOrInsert(
            ['jenjang' => 'S3'],
            ['nama' => 'Doktor', 'jumlah_semester' => 6]
        );
    }
}
