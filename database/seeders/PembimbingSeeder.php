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
        $pembimbingData = [
            'iin' => 'skripsi',
            'topan' => 'skripsi',
        ];

        foreach ($pembimbingData as $username => $jenisBimbingan) {
            $user = User::where('username', $username)->first();

            if (! $user) {
                continue; // skip jika user tidak ditemukan
            }

            $dosen = Dosen::where('user_id', $user->id)->first();

            if (! $dosen) {
                continue; // skip jika dosen tidak ditemukan
            }

            // Cek jika sudah ada agar tidak duplikasi
            Pembimbing::updateOrCreate(
                [
                    'dosen_id' => $dosen->id,
                    'jenis_bimbingan' => $jenisBimbingan,
                ],
                [
                    'nomor_surat'   => null,
                    'file_surat'    => null,
                    'tanggal_surat' => null,
                    'catatan'       => 'Pembimbing aktif.',
                    'is_active'     => true,
                ]
            );
        }
    }
}
