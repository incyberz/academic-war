<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        // Skip jika tabel belum ada
        if (!DB::getSchemaBuilder()->hasTable('prodi')) {
            return;
        }

        $data = [
            ['prodi' => 'AG',  'urutan' => 10, 'fakultas' => 'FAPERTA', 'nama' => 'Agribisnis',                  'jenjang' => 'S1'],
            ['prodi' => 'BD',  'urutan' => 3,  'fakultas' => 'FKOM',    'nama' => 'Bisnis Digital',             'jenjang' => 'S1'],
            ['prodi' => 'BI',  'urutan' => 8,  'fakultas' => 'FKIP',    'nama' => 'Pendidikan Bahasa Inggris', 'jenjang' => 'S1'],
            ['prodi' => 'BK',  'urutan' => 9,  'fakultas' => 'FKIP',    'nama' => 'Bimbingan dan Konseling',   'jenjang' => 'S1'],
            ['prodi' => 'IF',  'urutan' => 6,  'fakultas' => 'FTEK',    'nama' => 'Informatika',               'jenjang' => 'S1'],
            ['prodi' => 'KA',  'urutan' => 1,  'fakultas' => 'FKOM',    'nama' => 'Komputerisasi Akuntansi',   'jenjang' => 'D3'],
            ['prodi' => 'MBS', 'urutan' => 5,  'fakultas' => 'FEBI',    'nama' => 'Manajemen Bisnis Syariah',  'jenjang' => 'S1'],
            ['prodi' => 'PS',  'urutan' => 4,  'fakultas' => 'FEBI',    'nama' => 'Perbankan Syariah',         'jenjang' => 'S1'],
            ['prodi' => 'SI',  'urutan' => 2,  'fakultas' => 'FKOM',    'nama' => 'Sistem Informasi',          'jenjang' => 'S1'],
            ['prodi' => 'TI',  'urutan' => 7,  'fakultas' => 'FTEK',    'nama' => 'Teknik Industri',           'jenjang' => 'S1'],
            ['prodi' => 'TP',  'urutan' => 11, 'fakultas' => 'FAPERTA', 'nama' => 'Teknologi Pangan',          'jenjang' => 'S1'],
        ];

        foreach ($data as $row) {
            DB::table('prodi')->updateOrInsert(
                ['prodi' => $row['prodi']],
                $row
            );
        }
    }
}
