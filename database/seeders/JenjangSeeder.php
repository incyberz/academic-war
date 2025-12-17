<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenjangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'D1', 'nama' => 'Diploma 1', 'jumlah_semester' => 2],
            ['kode' => 'D2', 'nama' => 'Diploma 2', 'jumlah_semester' => 4],
            ['kode' => 'D3', 'nama' => 'Diploma 3', 'jumlah_semester' => 6],
            ['kode' => 'D4', 'nama' => 'Diploma 4 / Sarjana Terapan', 'jumlah_semester' => 8],
            ['kode' => 'S1', 'nama' => 'Sarjana', 'jumlah_semester' => 8],
            ['kode' => 'S2', 'nama' => 'Magister', 'jumlah_semester' => 4],
            ['kode' => 'S3', 'nama' => 'Doktor', 'jumlah_semester' => 6],
        ];

        foreach ($data as $row) {
            DB::table('jenjang')->updateOrInsert(
                ['kode' => $row['kode']], // unique key
                [
                    'nama' => $row['nama'],
                    'jumlah_semester' => $row['jumlah_semester'],
                ]
            );
        }
    }
}
