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
            ['nama' => 'Agribisnis',                  'fakultas' => 'FAPERTA', 'jenjang' => 'S1', 'urutan' => 10],
            ['nama' => 'Bisnis Digital',             'fakultas' => 'FKOM',    'jenjang' => 'S1', 'urutan' => 3],
            ['nama' => 'Pendidikan Bahasa Inggris', 'fakultas' => 'FKIP',    'jenjang' => 'S1', 'urutan' => 8],
            ['nama' => 'Bimbingan dan Konseling',   'fakultas' => 'FKIP',    'jenjang' => 'S1', 'urutan' => 9],
            ['nama' => 'Informatika',               'fakultas' => 'FTEK',    'jenjang' => 'S1', 'urutan' => 6],
            ['nama' => 'Komputerisasi Akuntansi',   'fakultas' => 'FKOM',    'jenjang' => 'D3', 'urutan' => 1],
            ['nama' => 'Manajemen Bisnis Syariah',  'fakultas' => 'FEBI',    'jenjang' => 'S1', 'urutan' => 5],
            ['nama' => 'Perbankan Syariah',         'fakultas' => 'FEBI',    'jenjang' => 'S1', 'urutan' => 4],
            ['nama' => 'Sistem Informasi',          'fakultas' => 'FKOM',    'jenjang' => 'S1', 'urutan' => 2],
            ['nama' => 'Teknik Industri',           'fakultas' => 'FTEK',    'jenjang' => 'S1', 'urutan' => 7],
            ['nama' => 'Teknologi Pangan',          'fakultas' => 'FAPERTA', 'jenjang' => 'S1', 'urutan' => 11],
        ];

        foreach ($data as $row) {
            DB::table('prodi')->updateOrInsert(
                ['nama' => $row['nama']], // gunakan nama sebagai unik sementara
                $row
            );
        }
    }
}
