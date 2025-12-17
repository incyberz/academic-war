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
                'tahun_ajar' => 20251,
                'aktif' => false,
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-06-30',
            ],
            [
                'tahun_ajar' => 20252,
                'aktif' => false,
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2025-12-31',
            ],
            [
                'tahun_ajar' => 20253,
                'aktif' => false,
                'tanggal_mulai' => null,
                'tanggal_selesai' => null,
            ],
            [
                'tahun_ajar' => 20261,
                'aktif' => false,
                'tanggal_mulai' => '2026-01-01',
                'tanggal_selesai' => '2026-06-30',
            ],
            [
                'tahun_ajar' => 20262,
                'aktif' => false,
                'tanggal_mulai' => '2026-07-01',
                'tanggal_selesai' => '2026-12-31',
            ],
            [
                'tahun_ajar' => 20263,
                'aktif' => false,
                'tanggal_mulai' => null,
                'tanggal_selesai' => null,
            ],
        ];

        foreach ($data as $row) {
            DB::table('tahun_ajar')->updateOrInsert(
                ['tahun_ajar' => $row['tahun_ajar']], // key unik
                [
                    'aktif' => $row['aktif'],
                    'tanggal_mulai' => $row['tanggal_mulai'],
                    'tanggal_selesai' => $row['tanggal_selesai'],
                ]
            );
        }
    }
}
