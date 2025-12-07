<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Pembimbing;

class PembimbingSeeder extends Seeder
{
    public function run(): void
    {
        /** ----------------------------
         *  Pembimbing: iin
         * ----------------------------*/
        $userIin = User::where('username', 'iin')->first();
        if ($userIin) {
            $dosenIin = Dosen::where('user_id', $userIin->id)->first();

            if ($dosenIin) {
                Pembimbing::create([
                    'dosen_id'       => $dosenIin->id,
                    'jenis_bimbingan' => 'skripsi',
                    'nomor_surat'    => null,
                    'file_surat'     => null,
                    'tanggal_surat'  => null,
                    'catatan'        => 'Pembimbing aktif.',
                    'is_active'      => true,
                ]);
            }
        }

        /** ----------------------------
         *  Pembimbing: topan
         * ----------------------------*/
        $userTopan = User::where('username', 'topan')->first();
        if ($userTopan) {
            $dosenTopan = Dosen::where('user_id', $userTopan->id)->first();

            if ($dosenTopan) {
                Pembimbing::create([
                    'dosen_id'       => $dosenTopan->id,
                    'jenis_bimbingan' => 'skripsi',
                    'nomor_surat'    => null,
                    'file_surat'     => null,
                    'tanggal_surat'  => null,
                    'catatan'        => 'Pembimbing aktif.',
                    'is_active'      => true,
                ]);
            }
        }
    }
}
