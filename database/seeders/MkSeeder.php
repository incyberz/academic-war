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

        $mks[1] = [
            ['nama' => 'Aljabar Linier (Vektor dan Matrik)', 'singkatan' => 'ALIN'],
            ['nama' => 'Bahasa Inggris 1 (For Accounting)', 'singkatan' => 'BING1A'],
            ['nama' => 'Bahasa Inggris 1 (For business)', 'singkatan' => 'BING1B'],
            ['nama' => 'Bahasa Inggris 1 (For Computer)', 'singkatan' => 'BING1C'],
            ['nama' => 'KPAM 1', 'singkatan' => 'KPAM1'],
            ['nama' => 'Logika dan Algoritma', 'singkatan' => 'LOGAL'],
            ['nama' => 'Matematika Ekonomi dan Bisnis', 'singkatan' => 'MATEKBIS'],
            ['nama' => 'Matematika Informatika', 'singkatan' => 'MATIF'],
            ['nama' => 'Pendidikan Agama Islam 1', 'singkatan' => 'PAI1'],
            ['nama' => 'Pendidikan Pancasila', 'singkatan' => 'PANCASILA'],
            ['nama' => 'Pengantar Akuntansi', 'singkatan' => 'PAK'],
            ['nama' => 'Pengantar Ilmu Ekonomi', 'singkatan' => 'PIE'],
            ['nama' => 'Pengantar Manajamen', 'singkatan' => 'PM'],
            ['nama' => 'Pengantar Manajamen dan Bisnis', 'singkatan' => 'PMB'],
            ['nama' => 'Pengantar Sistem dan Teknologi Informasi', 'singkatan' => 'PSTI'],
            ['nama' => 'PPN 1 (MS Office)', 'singkatan' => 'PPN1'],
        ];

        $mks[3] = [
            ['nama' => 'Akuntansi Biaya', 'singkatan' => 'AKBI'],
            ['nama' => 'Akuntansi Keuangan', 'singkatan' => 'AKK'],
            ['nama' => 'Analisa Proses Bisnis', 'singkatan' => 'APB'],
            ['nama' => 'Bahasa Inggris 2 (For Bussines)', 'singkatan' => 'BING2B'],
            ['nama' => 'Instalasi Komputer dan Jaringan', 'singkatan' => 'IKJ'],
            ['nama' => 'Manajemen Bisnis (E-Business)', 'singkatan' => 'MBEB'],
            ['nama' => 'Pemrograman Aplikasi Akuntansi 1', 'singkatan' => 'PAA1'],
            ['nama' => 'Pemrograman Java', 'singkatan' => 'JAVA'],
            ['nama' => 'Sistem Multimedia (Movie Maker)', 'singkatan' => 'SMM'],
            ['nama' => 'Riset Teknologi Informasi', 'singkatan' => 'RTI'],
            ['nama' => 'Pendidikan Anti Korupsi', 'singkatan' => 'PAKOR'],
            ['nama' => 'Pendidikan Kewarganegaraan', 'singkatan' => 'PKN'],
            ['nama' => 'PLSQL (Pemrograman Database)', 'singkatan' => 'PLSQL'],
            ['nama' => 'PPN 3 (Photoshop dan UI UX)', 'singkatan' => 'PPN3'],
            ['nama' => 'Sistem Basis Data', 'singkatan' => 'SBD'],
            ['nama' => 'Sistem Informasi Manajemen', 'singkatan' => 'SIM'],
            ['nama' => 'Studi Kelayakan Bisnis', 'singkatan' => 'SKB'],
            ['nama' => 'Perpajakan', 'singkatan' => 'PAJAK'],
            ['nama' => 'Kewirausahaan', 'singkatan' => 'KWU'],
            ['nama' => 'Pemrograman Web', 'singkatan' => 'PWEB'],
        ];

        $mks[5] = [
            ['nama' => 'Testing dan Implementasi SI', 'singkatan' => 'TISI'],
            ['nama' => 'Analisa dan Perancangan Sistem Informasi', 'singkatan' => 'APSI'],
            ['nama' => 'Metode Penelitian', 'singkatan' => 'METPEN'],
            ['nama' => 'Manajemen Resiko TI', 'singkatan' => 'MRTI'],
            ['nama' => 'Sistem Pendukung Keputusan', 'singkatan' => 'SPK'],
            ['nama' => 'Komunikasi Data', 'singkatan' => 'KOMDATA'],
            ['nama' => 'Leadership dan Comunication Skill', 'singkatan' => 'LCS'],
            ['nama' => 'StartUp dan Perencanaan Bisnis', 'singkatan' => 'STARTUP'],
            ['nama' => 'Bahasa Inggris 3 (Conversation)', 'singkatan' => 'BING3'],
            ['nama' => 'English Conversation', 'singkatan' => 'EC'],
            ['nama' => 'English Proficiency (TOEFL)', 'singkatan' => 'TOEFL'],
            ['nama' => 'KPAM 5', 'singkatan' => 'KPAM5'],
            ['nama' => 'Kontrol dan Audit Sistem Informasi', 'singkatan' => 'KASI'],
            ['nama' => 'Sistem Akuntansi', 'singkatan' => 'SAK'],
            ['nama' => 'Rekayasa Sistem Informasi', 'singkatan' => 'RSI'],
            ['nama' => 'Bahasa Indonesia', 'singkatan' => 'BINDO'],
            ['nama' => 'Pemrograman Mobile 2', 'singkatan' => 'PMOB2'],
            ['nama' => 'Pendidikan Agama Islam 3', 'singkatan' => 'PAI3'],
            ['nama' => 'Statistik Komputasi', 'singkatan' => 'STATKOM'],
            ['nama' => 'Struktur dan Perilaku Organisasi', 'singkatan' => 'SPO'],
            ['nama' => 'Manajemen Keuangan', 'singkatan' => 'MKEU'],
        ];

        $mks[7] = [
            ['nama' => 'Etika Profesi', 'singkatan' => 'ETPRO'],
            ['nama' => 'Manajemen Operasional', 'singkatan' => 'MOP'],
            ['nama' => 'Machine Learning', 'singkatan' => 'ML'],
            ['nama' => 'Sistem Multimedia', 'singkatan' => 'SMM2'],
            ['nama' => 'Teknik Peramalan', 'singkatan' => 'TP'],
            ['nama' => 'Riset Pasar Digital', 'singkatan' => 'RPD'],
            ['nama' => 'KPAM 7 (Skripsi)', 'singkatan' => 'KPAM7'],
            ['nama' => 'Manajemen Mutu Terpadu', 'singkatan' => 'MMT'],
            ['nama' => 'Ekonomi Makro', 'singkatan' => 'EMAK'],
            ['nama' => 'Enterprise Architecture Planning (ERP)', 'singkatan' => 'EAP'],
            ['nama' => 'Design Thinking', 'singkatan' => 'DT'],
            ['nama' => 'Statistik (SPSS)', 'singkatan' => 'SPSS'],
            ['nama' => 'Analisis Laporan Keuangan', 'singkatan' => 'ALK'],
        ];

        $mks[2] = [
            ['nama' => 'Akuntansi Keuangan Menengah', 'singkatan' => 'AKM'],
            ['nama' => 'Aplikasi Komputer Akuntansi (MYOB)', 'singkatan' => 'AKA'],
            ['nama' => 'Desain Grafis (UI UX)', 'singkatan' => 'DG'],
            ['nama' => 'Ekonomi Mikro', 'singkatan' => 'EM'],
            ['nama' => 'Etika Bisnis dan Profesi', 'singkatan' => 'EBP'],
            ['nama' => 'Komunikasi Bisnis', 'singkatan' => 'KOMBIS'],
            ['nama' => 'Kewarganegaraan', 'singkatan' => 'KWGN'],
            ['nama' => 'KPAM 2 (Teknik Penulisan Karya Ilmiah)', 'singkatan' => 'KPAM2'],
            ['nama' => 'Object Oriented Analisis Design', 'singkatan' => 'OOAD'],
            ['nama' => 'Pengantar Ilmu Ekonomi (Mikro dan Makro)', 'singkatan' => 'PIE2'],
            ['nama' => 'Program Niaga 2 (UI UX)', 'singkatan' => 'PN2'],
            ['nama' => 'Sistem Informasi Akuntansi', 'singkatan' => 'SIA'],
            ['nama' => 'Sistem Operasi', 'singkatan' => 'SO'],
            ['nama' => 'Statistik', 'singkatan' => 'STT'],
        ];

        $mks[4] = [
            ['nama' => 'Content Creator', 'singkatan' => 'CC'],
            ['nama' => 'Customer Relationship Management', 'singkatan' => 'CRM'],
            ['nama' => 'Cyber Preneurship', 'singkatan' => 'CP'],
            ['nama' => 'Geographic Information System (GIS)', 'singkatan' => 'GIS'],
            ['nama' => 'KPAM 4 (Praktik Adaptasi Lapangan)', 'singkatan' => 'KPAM4'],
            ['nama' => 'Manajemen Kualitas Sistem Informasi', 'singkatan' => 'MKSI'],
            ['nama' => 'Manajemen Pemasaran', 'singkatan' => 'MP'],
            ['nama' => 'Manajemen Proyek Sistem Informasi', 'singkatan' => 'MPSI'],
            ['nama' => 'Manajemen SDM', 'singkatan' => 'MSDM'],
            ['nama' => 'Pemrograman Mobile 1', 'singkatan' => 'PMOB1'],
            ['nama' => 'Pemrograman Visual', 'singkatan' => 'PV'],
            ['nama' => 'Pemrograman Web Mobile', 'singkatan' => 'PWM'],
            ['nama' => 'Perilaku Organisasi', 'singkatan' => 'PO'],
            ['nama' => 'Program Niaga 3 (UI UX)', 'singkatan' => 'PN3'],
            ['nama' => 'Struktur Data', 'singkatan' => 'STRUKDAT'],
        ];

        $mks[6] = [
            ['nama' => 'Data Mining', 'singkatan' => 'DM'],
            ['nama' => 'Data Science', 'singkatan' => 'DS'],
            ['nama' => 'E-Business', 'singkatan' => 'EB'],
            ['nama' => 'Enterprise Arsitektur', 'singkatan' => 'EA'],
            ['nama' => 'Enterprise Resource Planning (ERP)', 'singkatan' => 'ERP'],
            ['nama' => 'KPAM 6 (Kuliah Kerja Nyata)', 'singkatan' => 'KPAM6'],
            ['nama' => 'Manajemen Proyek', 'singkatan' => 'MPR'],
            ['nama' => 'Manajemen Strategi dan Resiko', 'singkatan' => 'MSR'],
            ['nama' => 'Pemeriksaan Akuntansi', 'singkatan' => 'PA'],
            ['nama' => 'Supply Chain Management', 'singkatan' => 'SCM'],
        ];

        $mks[8] = [
            ['nama' => 'Skripsi', 'singkatan' => 'SKRIPSI'],
        ];


        foreach ($mks as $semester => $mataKuliah) {
            foreach ($mataKuliah as $mk) {
                DB::table('mk')->updateOrInsert(
                    ['nama' => $mk['nama']], // key unik
                    [
                        'kode' => Str::upper(Str::slug($mk['singkatan'], '')),
                        'nama' => $mk['nama'],
                        'singkatan' => $mk['singkatan'],
                        'sks' => 2, // default SKS, bisa disesuaikan
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
