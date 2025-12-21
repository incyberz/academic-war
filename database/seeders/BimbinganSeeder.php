<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bimbingan;

class BimbinganSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id' => 1, 'pembimbing_id' => 1, 'jenis_bimbingan_id' => 1, 'tahun_ajar_id' => 20251],
            ['id' => 2, 'pembimbing_id' => 1, 'jenis_bimbingan_id' => 2, 'tahun_ajar_id' => 20251],
            ['id' => 3, 'pembimbing_id' => 2, 'jenis_bimbingan_id' => 1, 'tahun_ajar_id' => 20251],
            ['id' => 4, 'pembimbing_id' => 2, 'jenis_bimbingan_id' => 2, 'tahun_ajar_id' => 20251],
        ];

        foreach ($data as $row) {
            Bimbingan::updateOrCreate(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
