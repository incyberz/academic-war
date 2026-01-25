<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusMhsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('status_mhs')->upsert(
            [
                [
                    'kode' => 'AKTIF',
                    'nama' => 'Aktif',
                    'keterangan' => 'Mahasiswa terdaftar dan mengikuti kegiatan akademik',
                    'boleh_krs' => true,
                    'boleh_kuliah' => true,
                    'boleh_login' => true,
                    'boleh_bimbingan' => true,
                ],
                [
                    'kode' => 'CUTI',
                    'nama' => 'Cuti',
                    'keterangan' => 'Mahasiswa izin tidak mengikuti perkuliahan pada semester berjalan',
                    'boleh_krs' => false,
                    'boleh_kuliah' => false,
                    'boleh_login' => true,
                    'boleh_bimbingan' => false,
                ],
                [
                    'kode' => 'NONAKTIF',
                    'nama' => 'Non Aktif',
                    'keterangan' => 'Mahasiswa tidak aktif karena administrasi atau alasan tertentu',
                    'boleh_krs' => false,
                    'boleh_kuliah' => false,
                    'boleh_login' => false,
                    'boleh_bimbingan' => false,
                ],
                [
                    'kode' => 'LULUS',
                    'nama' => 'Lulus',
                    'keterangan' => 'Mahasiswa telah menyelesaikan seluruh kewajiban akademik',
                    'boleh_krs' => false,
                    'boleh_kuliah' => false,
                    'boleh_login' => false,
                    'boleh_bimbingan' => false,
                ],
                [
                    'kode' => 'DO',
                    'nama' => 'Drop Out',
                    'keterangan' => 'Mahasiswa dikeluarkan dari program studi',
                    'boleh_krs' => false,
                    'boleh_kuliah' => false,
                    'boleh_login' => false,
                    'boleh_bimbingan' => false,
                ],
            ],
            ['kode'], // unique key
            [
                'nama',
                'keterangan',
                'boleh_krs',
                'boleh_kuliah',
                'boleh_login',
                'boleh_bimbingan',
                'updated_at',
            ]
        );
    }
}
