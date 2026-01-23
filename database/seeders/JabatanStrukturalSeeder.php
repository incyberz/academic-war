<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JabatanStrukturalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jabatan_struktural')->truncate();

        DB::table('jabatan_struktural')->insert([
            [
                'id' => 1,
                'user_id' => 1, // contoh: dosen kaprodi
                'prodi_id' => 1,
                'jabatan' => 'kaprodi',
                'asal_sdm' => 'dosen',
                'plt' => false,
                'boleh_acc_krs' => true,
                'boleh_acc_cuti' => true,
                'boleh_bimbingan' => true,
                'boleh_ubah_kurikulum' => true,
                'periode_mulai' => '2023-08-01',
                'periode_selesai' => null,
                'aktif' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => 2,
                'user_id' => 2, // contoh: tendik sekprodi
                'prodi_id' => 1,
                'jabatan' => 'sekprodi',
                'asal_sdm' => 'tendik',
                'plt' => false,
                'boleh_acc_krs' => false,
                'boleh_acc_cuti' => false,
                'boleh_bimbingan' => false,
                'boleh_ubah_kurikulum' => false,
                'periode_mulai' => '2023-08-01',
                'periode_selesai' => null,
                'aktif' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => 3,
                'user_id' => 3, // contoh: dosen sebagai sekprodi
                'prodi_id' => 2,
                'jabatan' => 'sekprodi',
                'asal_sdm' => 'dosen',
                'plt' => false,
                'boleh_acc_krs' => true,
                'boleh_acc_cuti' => true,
                'boleh_bimbingan' => true,
                'boleh_ubah_kurikulum' => false,
                'periode_mulai' => '2024-02-01',
                'periode_selesai' => null,
                'aktif' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => 4,
                'user_id' => 4, // contoh: PLT sekprodi dari tendik
                'prodi_id' => 3,
                'jabatan' => 'sekprodi',
                'asal_sdm' => 'tendik',
                'plt' => true,
                'boleh_acc_krs' => false,
                'boleh_acc_cuti' => false,
                'boleh_bimbingan' => false,
                'boleh_ubah_kurikulum' => false,
                'periode_mulai' => '2024-09-01',
                'periode_selesai' => '2025-02-28',
                'aktif' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
