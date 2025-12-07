<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        // Jika tabel tidak ada, skip seeding
        if (!DB::getSchemaBuilder()->hasTable('fakultas')) {
            return;
        }

        $data = [
            ['fakultas' => 'FAPERTA', 'urutan' => 4, 'nama' => 'Fakultas Pertanian'],
            ['fakultas' => 'FEBI',    'urutan' => 2, 'nama' => 'Fakultas Ekonomi dan Bisnis Syariah'],
            ['fakultas' => 'FKIP',    'urutan' => 3, 'nama' => 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['fakultas' => 'FKOM',    'urutan' => 1, 'nama' => 'Fakultas Komputer'],
            ['fakultas' => 'FTEK',    'urutan' => 5, 'nama' => 'Fakultas Teknik'],
        ];

        foreach ($data as $row) {
            DB::table('fakultas')->updateOrInsert(
                ['fakultas' => $row['fakultas']],
                [
                    'urutan' => $row['urutan'],
                    'nama'   => $row['nama'],
                ]
            );
        }
    }
}
