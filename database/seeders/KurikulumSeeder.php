<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use App\Models\Prodi;
use Illuminate\Database\Seeder;

class KurikulumSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = 2025;
        $prodis = Prodi::all();

        foreach ($prodis as $prodi) {
            Kurikulum::firstOrCreate(
                [
                    'prodi_id' => $prodi->id,
                    'tahun'    => $tahun,
                ],
                [
                    // isi field tambahan kalau ada, misal:
                    'keterangan' => 'Created by KurikulumSeeder',
                ]
            );
        }
    }
}
