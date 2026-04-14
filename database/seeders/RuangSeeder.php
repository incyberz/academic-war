<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruang;

class RuangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'ZOOM', 'kapasitas' => 500, 'gedung' => null, 'jenis_ruang' => 'kelas', 'is_ready' => true],

            ['nama' => 'A201', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A202', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A203', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A204', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A205', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A206', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A207', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A208', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A209', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A210', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A211', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A212', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A222', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],
            ['nama' => 'A223', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'kelas', 'is_ready' => true],

            ['nama' => 'Aula', 'kapasitas' => 100, 'gedung' => 'A', 'jenis_ruang' => 'aula', 'is_ready' => true],

            ['nama' => 'LJ',   'kapasitas' => 40, 'gedung' => 'B', 'jenis_ruang' => 'lab', 'is_ready' => true],
            ['nama' => 'LB',   'kapasitas' => 40, 'gedung' => 'B', 'jenis_ruang' => 'lab', 'is_ready' => true],
            ['nama' => 'B301', 'kapasitas' => 40, 'gedung' => 'B', 'jenis_ruang' => 'lab', 'is_ready' => true],
            ['nama' => 'B302', 'kapasitas' => 40, 'gedung' => 'B', 'jenis_ruang' => 'lab', 'is_ready' => true],
            ['nama' => 'B303', 'kapasitas' => 40, 'gedung' => 'B', 'jenis_ruang' => 'lab', 'is_ready' => true],
            ['nama' => 'B304', 'kapasitas' => 40, 'gedung' => 'B', 'jenis_ruang' => 'lab', 'is_ready' => true],
            ['nama' => 'A301', 'kapasitas' => 40, 'gedung' => 'A', 'jenis_ruang' => 'lab', 'is_ready' => true],
        ];

        foreach ($data as $item) {
            $item['kode'] = $item['nama']; // kode = nama

            Ruang::updateOrCreate(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}
