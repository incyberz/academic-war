<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Pembimbing;
use Illuminate\Support\Facades\DB;


class PembimbingSeeder extends Seeder
{
    public function run(): void
    {

        // insert data ke tabel jenis bimbingan
        DB::table('jenis_bimbingan')->updateOrInsert(
            ['kode' => 'skripsi'],
            [
                'nama' => 'Bimbingan Skripsi',
                'deskripsi' => 'Untuk Jenjang S1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('jenis_bimbingan')->updateOrInsert(
            ['kode' => 'pkl'],
            [
                'nama' => 'Bimbingan PKL',
                'deskripsi' => 'Untuk Jenjang S1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $pembimbingData = [
            'iin' => 'skripsi',
            'iin' => 'pkl',
            'topan' => 'skripsi',
        ];

        foreach ($pembimbingData as $username => $jenisBimbingan) {

            $jenisBimbinganId = DB::table('jenis_bimbingan')->where('kode', $jenisBimbingan)->value('id');
            if (! $jenisBimbinganId) {
                // stop jika jenis bimbingan tidak ditemukan
                dd("Jenis bimbingan dengan kode {$jenisBimbingan} tidak ditemukan.");
            }

            $user = User::where('username', $username)->first();

            if (! $user) {
                // stop jika user tidak ditemukan
                dd("User dengan username {$username} tidak ditemukan.");
            }

            $dosen = Dosen::where('user_id', $user->id)->first();

            if (! $dosen) {
                // stop jika dosen tidak ditemukan
                dd("Dosen untuk user_id {$user->id} tidak ditemukan.");
            }

            // Cek jika sudah ada agar tidak duplikasi
            Pembimbing::updateOrCreate(
                [
                    'dosen_id' => $dosen->id,
                    // 'jenis_bimbingan_id' => $jenisBimbinganId,
                ],
                [
                    'nomor_surat'   => null,
                    'file_surat'    => null,
                    'tanggal_surat' => null,
                    'catatan'       => 'Pembimbing aktif by Seeder.',
                    'is_active'     => true,
                ]
            );
        }
    }
}
