<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusAkademikSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('status_akademik')->insertOrIgnore([
            [
                'id' => 1,
                'kode' => 'AKTIF',
                'nama' => 'Aktif',
                'keterangan' => 'Mahasiswa terdaftar dan mengikuti kegiatan akademik',
                'boleh_krs' => true,
                'boleh_kuliah' => true,
                'boleh_login' => true,
                'boleh_bimbingan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'kode' => 'CUTI',
                'nama' => 'Cuti',
                'keterangan' => 'Mahasiswa izin tidak mengikuti perkuliahan pada semester berjalan',
                'boleh_login' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'kode' => 'NONAKTIF',
                'nama' => 'Non Aktif',
                'keterangan' => 'Mahasiswa tidak aktif karena administrasi atau alasan tertentu',
                'boleh_login' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'kode' => 'LULUS',
                'nama' => 'Lulus',
                'keterangan' => 'Mahasiswa telah menyelesaikan seluruh kewajiban akademik',
                'boleh_login' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'kode' => 'DO',
                'nama' => 'Drop Out',
                'keterangan' => 'Mahasiswa dikeluarkan dari program studi',
                'boleh_login' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
