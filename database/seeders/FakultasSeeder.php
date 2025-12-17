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
            ['kode' => 'FAPERTA', 'urutan' => 4, 'nama' => 'Fakultas Pertanian'],
            ['kode' => 'FEBI',    'urutan' => 2, 'nama' => 'Fakultas Ekonomi dan Bisnis Syariah'],
            ['kode' => 'FKIP',    'urutan' => 3, 'nama' => 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['kode' => 'FKOM',    'urutan' => 1, 'nama' => 'Fakultas Komputer'],
            ['kode' => 'FTEK',    'urutan' => 5, 'nama' => 'Fakultas Teknik'],
        ];

        foreach ($data as $row) {
            DB::table('fakultas')->updateOrInsert(
                ['kode' => $row['kode']], // gunakan field kode sebagai unique identifier
                [
                    'urutan' => $row['urutan'],
                    'nama'   => $row['nama'],
                ]
            );
        }
    }
}
