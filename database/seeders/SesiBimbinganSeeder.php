<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SesiBimbinganSeeder extends Seeder
{
    public function run(): void
    {
        $statusList = array_keys(config('status_sesi_bimbingan'));

        $now = Carbon::now();

        $data = [];

        $minTahapanId = 1;
        $maxTahapanId = 22;

        for ($i = 1; $i <= 10; $i++) {

            $randStatus = $statusList[array_rand($statusList)];

            $createdAt = $now->copy()->subDays(10 - $i);

            $data[] = [
                'peserta_bimbingan_id'       => 1,
                'status_sesi_bimbingan' => $randStatus,
                'tahapan_bimbingan_id' => rand($minTahapanId, $maxTahapanId),

                'pesan_mhs'   => "Pesan mahasiswa sesi ke-$i (dummy)",
                'pesan_dosen' => "Tanggapan dosen sesi ke-$i (dummy)",

                'file_bimbingan' => "bab_{$i}.docx",
                'file_review'    => "bab_{$i}_reviewed.docx",

                'tanggal_review' => $createdAt->copy()->addHours(2),

                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        DB::table('sesi_bimbingan')->insert($data);
    }
}
