<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mks = [];

        // semester 1
        $mks[1] = [
            ['nama' => 'Pancasila dan Kewarganegaraan', 'singkatan' => 'PPKN'],
            ['nama' => 'Aljabar Linear', 'singkatan' => 'ALIN'],
            ['nama' => 'Bahasa Inggris', 'singkatan' => 'B.ING'],
            ['nama' => 'Logika Informatika', 'singkatan' => 'LOGIF'],
            ['nama' => 'Struktur Data', 'singkatan' => 'STRUKDAT'],
            ['nama' => 'Pengantar Teknologi Informasi', 'singkatan' => 'PTI'],
            ['nama' => 'Algoritma dan Pemrograman', 'singkatan' => 'ALPRO'],
            ['nama' => 'Matematika Diskrit', 'singkatan' => 'MATDIS'],
            ['nama' => 'Arsitektur dan Organisasi Komputer', 'singkatan' => 'ARKOM'],
        ];

        // semester 3
        $mks[3] = [
            ['nama' => 'Sistem Operasi', 'singkatan' => 'SISOP'],
            ['nama' => 'Statistik dan Probabilitas', 'singkatan' => 'STAT'],
            ['nama' => 'Analisis dan Desain Sistem', 'singkatan' => 'ADS'],
            ['nama' => 'Basis Data', 'singkatan' => 'BASDAT'],
            ['nama' => 'Pemrograman Berorientasi Objek', 'singkatan' => 'PBO'],
            ['nama' => 'Jaringan Komputer', 'singkatan' => 'JARKOM'],
            ['nama' => 'Etika Profesi', 'singkatan' => 'ETIKA'],
            ['nama' => 'Interaksi Manusia dan Komputer', 'singkatan' => 'IMK'],
        ];

        $mks[5] = [
            ['nama' => 'Pemrograman Web', 'singkatan' => 'WEB'],
            ['nama' => 'Rekayasa Perangkat Lunak', 'singkatan' => 'RPL'],
            ['nama' => 'Kecerdasan Buatan', 'singkatan' => 'AI'],
            ['nama' => 'Manajemen Proyek TI', 'singkatan' => 'MPTI'],
            ['nama' => 'Sistem Informasi Manajemen', 'singkatan' => 'SIM'],
            ['nama' => 'Keamanan Informasi', 'singkatan' => 'KAMSI'],
            ['nama' => 'E-Commerce', 'singkatan' => 'ECOMM'],
            ['nama' => 'Technopreneurship', 'singkatan' => 'TECHNO'],
        ];

        $mks[7] = [
            ['nama' => 'Metodologi Penelitian', 'singkatan' => 'METLIT'],
            ['nama' => 'Etika Profesi IT', 'singkatan' => 'ETIKA IT'],
            ['nama' => 'Data Warehouse & Business Intelligence', 'singkatan' => 'DWBI'],
            ['nama' => 'Sistem Pendukung Keputusan', 'singkatan' => 'SPK'],
            ['nama' => 'Audit Sistem Informasi', 'singkatan' => 'AUDIT SI'],
            ['nama' => 'Pengujian Perangkat Lunak', 'singkatan' => 'TESTING'],
            ['nama' => 'Cloud Computing', 'singkatan' => 'CLOUD'],
            ['nama' => 'Kapita Selekta', 'singkatan' => 'KAPSEL'],
        ];

        foreach ($mks as $semester => $mataKuliah) {
            foreach ($mataKuliah as $mk) {
                DB::table('mk')->updateOrInsert(
                    ['nama' => $mk['nama']], // key unik
                    [
                        'kode' => Str::upper(Str::slug($mk['singkatan'], '')),
                        'nama' => $mk['nama'],
                        'singkatan' => $mk['singkatan'],
                        'sks' => 3, // default SKS, bisa disesuaikan
                        'rekom_semester' => $semester,
                        'rekom_fakultas' => 'FKOM',
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
