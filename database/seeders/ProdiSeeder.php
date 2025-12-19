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
            ['prodi' => 'AG', 'nama' => 'Agribisnis',                  'fakultas' => 'FAPERTA', 'jenjang' => 'S1', 'urutan' => 10],
            ['prodi' => 'BD', 'nama' => 'Bisnis Digital',             'fakultas' => 'FKOM',    'jenjang' => 'S1', 'urutan' => 3],
            ['prodi' => 'BG', 'nama' => 'Pendidikan Bahasa Inggris', 'fakultas' => 'FKIP',    'jenjang' => 'S1', 'urutan' => 8],
            ['prodi' => 'BK', 'nama' => 'Bimbingan dan Konseling',   'fakultas' => 'FKIP',    'jenjang' => 'S1', 'urutan' => 9],
            ['prodi' => 'IF', 'nama' => 'Informatika',               'fakultas' => 'FTEK',    'jenjang' => 'S1', 'urutan' => 6],
            ['prodi' => 'KA', 'nama' => 'Komputerisasi Akuntansi',   'fakultas' => 'FKOM',    'jenjang' => 'D3', 'urutan' => 1],
            ['prodi' => 'MBS', 'nama' => 'Manajemen Bisnis Syariah',  'fakultas' => 'FEBI',    'jenjang' => 'S1', 'urutan' => 5],
            ['prodi' => 'PS', 'nama' => 'Perbankan Syariah',         'fakultas' => 'FEBI',    'jenjang' => 'S1', 'urutan' => 4],
            ['prodi' => 'SI', 'nama' => 'Sistem Informasi',          'fakultas' => 'FKOM',    'jenjang' => 'S1', 'urutan' => 2],
            ['prodi' => 'TI', 'nama' => 'Teknik Industri',           'fakultas' => 'FTEK',    'jenjang' => 'S1', 'urutan' => 7],
            ['prodi' => 'TP', 'nama' => 'Teknologi Pangan',          'fakultas' => 'FAPERTA', 'jenjang' => 'S1', 'urutan' => 11],
        ];

        foreach ($data as $row) {
            $fakultas = DB::table('fakultas')->where('kode', $row['fakultas'])->first();
            $fakultasId = $fakultas ? $fakultas->id : null;
            if (!$fakultasId) {
                // stop jika fakultas tidak ditemukan
                dd("Fakultas dengan kode {$row['fakultas']} tidak ditemukan.");
            }

            DB::table('prodi')->updateOrInsert(
                ['prodi' => $row['prodi']], // gunakan nama sebagai unik sementara
                [
                    'fakultas_id' => $fakultasId,
                    'nama'     => $row['nama'],
                    'jenjang'     => $row['jenjang'],
                    'urutan'      => $row['urutan'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }
    }
}
