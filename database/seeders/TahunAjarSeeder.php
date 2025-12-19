<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 20251,
                'aktif' => true, // ⬅️ set default aktif
                'tanggal_mulai' => '2025-08-01',
                'tanggal_selesai' => '2026-03-31',
            ],
            [
                'id' => 20252,
                'aktif' => false,
                'tanggal_mulai' => '2026-04-01',
                'tanggal_selesai' => '2026-07-31',
            ],
            [
                'id' => 20261,
                'aktif' => false,
                'tanggal_mulai' => '2026-08-01',
                'tanggal_selesai' => '2027-03-31',
            ],
            [
                'id' => 20262,
                'aktif' => false,
                'tanggal_mulai' => '2027-04-01',
                'tanggal_selesai' => '2027-07-31',
            ],
        ];

        foreach ($data as $row) {
            DB::table('tahun_ajar')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );
        }
    }
}
