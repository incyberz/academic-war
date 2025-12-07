<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBimbinganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_bimbingan')->upsert(
            [
                [
                    'jenis_bimbingan' => 'pkl',
                    'nama' => 'Pembimbingan PKL',
                    'deskripsi' => 'Pembimbingan untuk kegiatan Praktik Kerja Lapangan.',
                ],
                [
                    'jenis_bimbingan' => 'skripsi',
                    'nama' => 'Pembimbingan Skripsi',
                    'deskripsi' => 'Pembimbingan untuk penyusunan skripsi mahasiswa.',
                ],
                [
                    'jenis_bimbingan' => 'kkn',
                    'nama' => 'Pembimbingan KKN',
                    'deskripsi' => 'Pembimbingan untuk kegiatan Kuliah Kerja Nyata.',
                ],
            ],
            ['jenis_bimbingan'], // primary key
            ['nama', 'deskripsi'] // update fields if exists
        );
    }
}
