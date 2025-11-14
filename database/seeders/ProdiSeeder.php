<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {

        // Ambil daftar fakultas: nama => id
        $fak = DB::table('fakultas')->pluck('id', 'nama');

        $json = [
            "Fakultas Ekonomi dan Bisnis Syariah" => [
                ["kode" => "PS",  "nama" => "Perbankan Syariah", "jenjang" => "S1"],
                ["kode" => "MBS", "nama" => "Manajemen Bisnis Syariah", "jenjang" => "S1"],
            ],
            "Fakultas Komputer" => [
                ["kode" => "SI", "nama" => "Sistem Informasi", "jenjang" => "S1"],
                ["kode" => "BD", "nama" => "Bisnis Digital", "jenjang" => "S1"],
                ["kode" => "KA", "nama" => "Komputerisasi Akuntansi", "jenjang" => "D3"],
            ],
            "Fakultas Pertanian" => [
                ["kode" => "AG", "nama" => "Agribisnis", "jenjang" => "S1"],
                ["kode" => "TP", "nama" => "Teknologi Pangan", "jenjang" => "S1"],
            ],
            "Fakultas Keguruan dan Ilmu Pendidikan" => [
                ["kode" => "BI", "nama" => "Pendidikan Bahasa Inggris", "jenjang" => "S1"],
                ["kode" => "BK", "nama" => "Bimbingan dan Konseling", "jenjang" => "S1"],
            ],
            "Fakultas Teknik" => [
                ["kode" => "TI", "nama" => "Teknik Industri", "jenjang" => "S1"],
                ["kode" => "IF", "nama" => "Informatika", "jenjang" => "S1"],
            ],
        ];

        $insert = [];

        foreach ($json as $namaFakultas => $prodiList) {
            if (!isset($fak[$namaFakultas])) {
                $this->command->warn("Fakultas tidak ditemukan di DB: " . $namaFakultas);
                continue;
            }

            foreach ($prodiList as $p) {
                $insert[] = [
                    'fakultas_id' => $fak[$namaFakultas],
                    'kode'        => $p['kode'],
                    'nama'        => $p['nama'],
                    'jenjang'     => $p['jenjang'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        DB::table('prodi')->insert($insert);
    }
}
