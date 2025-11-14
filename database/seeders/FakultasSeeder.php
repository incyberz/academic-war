<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fakultas')->insert([
            [
                'kode' => 'fkom',
                'nama' => 'Fakultas Komputer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'ftek',
                'nama' => 'Fakultas Teknik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'febi',
                'nama' => 'Fakultas Ekonomi dan Bisnis Syariah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'faperta',
                'nama' => 'Fakultas Pertanian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'fkip',
                'nama' => 'Fakultas Keguruan dan Ilmu Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
