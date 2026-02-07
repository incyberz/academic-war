<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamSesiSeeder extends Seeder
{
    public function run(): void
    {
        $jamSesis = [
            ['urutan' => 1,  'jam_mulai' => '07:30', 'jam_selesai' => '08:20'],
            ['urutan' => 2,  'jam_mulai' => '08:20', 'jam_selesai' => '09:10'],
            ['urutan' => 3,  'jam_mulai' => '09:10', 'jam_selesai' => '10:00'],
            ['urutan' => 4,  'jam_mulai' => '10:00', 'jam_selesai' => '10:50'],
            ['urutan' => 5,  'jam_mulai' => '10:50', 'jam_selesai' => '11:40'],
            ['urutan' => 6,  'jam_mulai' => '11:40', 'jam_selesai' => '12:30'],
            ['urutan' => 7,  'jam_mulai' => '12:30', 'jam_selesai' => '13:20'],
            ['urutan' => 8,  'jam_mulai' => '13:20', 'jam_selesai' => '14:10'],
            ['urutan' => 9,  'jam_mulai' => '14:10', 'jam_selesai' => '15:00'],
            ['urutan' => 10, 'jam_mulai' => '15:00', 'jam_selesai' => '15:50'],
            ['urutan' => 11, 'jam_mulai' => '15:50', 'jam_selesai' => '16:40'],
            ['urutan' => 12, 'jam_mulai' => '17:20', 'jam_selesai' => '18:10'],
            ['urutan' => 13, 'jam_mulai' => '18:10', 'jam_selesai' => '19:00'],
            ['urutan' => 14, 'jam_mulai' => '19:00', 'jam_selesai' => '19:50'],
            ['urutan' => 15, 'jam_mulai' => '19:50', 'jam_selesai' => '20:40'],
            ['urutan' => 16, 'jam_mulai' => '20:40', 'jam_selesai' => '21:30'],
        ];

        $now  = now();
        $rows = [];

        /**
         * Global blocked urutan + keterangannya
         */
        $globalBlocked = [
            7  => 'Jam istirahat',
            11 => 'Terlalu sore',
            16 => 'Terlalu malam',
        ];

        for ($weekday = 1; $weekday <= 6; $weekday++) {

            foreach ($jamSesis as $item) {

                // ==========================
                // SHIFT DARI URUTAN JAM
                // ==========================
                $shiftId = $item['urutan'] <= 11 ? 1 : 2;

                $canChartered = true;
                $keterangan   = null;

                // ==========================
                // SABTU: LIBUR TOTAL
                // ==========================
                if ($weekday === 6) {
                    $canChartered = false;
                    $keterangan   = 'Libur';
                }

                // ==========================
                // GLOBAL BLOCKED URUTAN
                // ==========================
                if (isset($globalBlocked[$item['urutan']])) {
                    $canChartered = false;
                    $keterangan   = $globalBlocked[$item['urutan']];
                }

                // ==========================
                // JUMAT: PERSIAPAN JUMATAN
                // ==========================
                if ($weekday === 5 && $item['urutan'] === 6) {
                    $canChartered = false;
                    $keterangan   = 'Persiapan Jumatan';
                }

                $rows[] = [
                    'shift_id'      => $shiftId,
                    'weekday'       => $weekday,
                    'urutan'        => $item['urutan'],
                    'jam_mulai'     => $item['jam_mulai'],
                    'jam_selesai'   => $item['jam_selesai'],
                    'can_chartered' => $canChartered,
                    'keterangan'    => $keterangan,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];
            }
        }

        // DB::table('jam_sesi')->truncate();
        DB::table('jam_sesi')->insert($rows);
    }
}


// php artisan db:seed --class=JamSesiSeeder --force
