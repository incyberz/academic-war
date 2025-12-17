<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBimbinganSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan tabel ada
        if (!DB::getSchemaBuilder()->hasTable('jenis_bimbingan')) {
            return;
        }

        $data = [
            [
                'kode' => 'pkl',
                'nama' => 'Pembimbingan PKL',
                'deskripsi' => 'Pembimbingan untuk kegiatan Praktik Kerja Lapangan.',
            ],
            [
                'kode' => 'skripsi',
                'nama' => 'Pembimbingan Skripsi',
                'deskripsi' => 'Pembimbingan untuk penyusunan skripsi mahasiswa.',
            ],
            [
                'kode' => 'kkn',
                'nama' => 'Pembimbingan KKN',
                'deskripsi' => 'Pembimbingan untuk kegiatan Kuliah Kerja Nyata.',
            ],
        ];

        foreach ($data as $row) {
            DB::table('jenis_bimbingan')->updateOrInsert(
                ['kode' => $row['kode']], // identifier unik
                [
                    'nama' => $row['nama'],
                    'deskripsi' => $row['deskripsi'],
                ]
            );
        }
    }
}
