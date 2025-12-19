<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBimbinganSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan tabel ada
        if (!DB::getSchemaBuilder()->hasTable('jenis_bimbingan')) {
            return;
        }

        $data = [
            [
                'kode' => 'pkl',
                'nama' => 'Pembimbingan PKL',
                'deskripsi' => 'Pembimbingan untuk kegiatan Praktik Kerja Lapangan.',
            ],
            [
                'kode' => 'skripsi',
                'nama' => 'Pembimbingan Skripsi',
                'deskripsi' => 'Untuk mahasiswa program sarjana (S1).',
            ],
            [
                'kode' => 'ta',
                'nama' => 'Tugas Akhir',
                'deskripsi' => 'Tugas Akhir untuk Diploma 3',
            ],
            [
                'kode' => 'kkn',
                'nama' => 'Kuliah Kerja Nyata',
                'deskripsi' => 'Pembimbingan kegiatan Kuliah Kerja Nyata mahasiswa.',
            ],
            [
                'kode' => 'pwl',
                'nama' => 'Bimbingan Perwalian',
                'deskripsi' => 'Bimbingan akademik wali dosen terkait KRS, studi, dan evaluasi.',
            ],
            [
                'kode' => 'ppl',
                'nama' => 'Praktik Pengenalan Lapangan',
                'deskripsi' => 'Praktik Pengenalan Lapangan untuk mahasiswa semester awal.',
            ],
            [
                'kode' => 'pal',
                'nama' => 'Praktik Adaptasi Lapangan',
                'deskripsi' => 'Praktik Adaptasi Lapangan untuk mahasiswa semester menengah.',
            ],


            [
                'kode' => 'kp',
                'nama' => 'Kerja Praktik',
                'deskripsi' => 'Bimbingan Kerja Praktik mahasiswa program sarjana.',
            ],
            [
                'kode' => 'mbkm',
                'nama' => 'MBKM',
                'deskripsi' => 'Bimbingan kegiatan Merdeka Belajar Kampus Merdeka.',
            ],
            [
                'kode' => 'tesis',
                'nama' => 'Pembimbingan Tesis',
                'deskripsi' => 'Bimbingan tesis mahasiswa program magister (S2).',
            ],
            [
                'kode' => 'disertasi',
                'nama' => 'Pembimbingan Disertasi',
                'deskripsi' => 'Bimbingan disertasi mahasiswa program doktor (S3).',
            ],
            [
                'kode' => 'riset',
                'nama' => 'Bimbingan Riset',
                'deskripsi' => 'Bimbingan penelitian dan publikasi ilmiah mahasiswa.',
            ],
            [
                'kode' => 'kompetisi',
                'nama' => 'Bimbingan Kompetisi',
                'deskripsi' => 'Bimbingan lomba akademik dan non-akademik mahasiswa.',
            ],
            [
                'kode' => 'karier',
                'nama' => 'Bimbingan Karier',
                'deskripsi' => 'Bimbingan persiapan karier, magang, dan dunia kerja.',
            ],
            [
                'kode' => 'konseling',
                'nama' => 'Bimbingan Konseling',
                'deskripsi' => 'Bimbingan non-akademik terkait pribadi dan sosial mahasiswa.',
            ],
            [
                'kode' => 'remedial',
                'nama' => 'Bimbingan Remedial',
                'deskripsi' => 'Bimbingan perbaikan akademik bagi mahasiswa bermasalah.',
            ],
        ];


        foreach ($data as $row) {
            DB::table('jenis_bimbingan')->updateOrInsert(
                ['kode' => $row['kode']], // identifier unik
                [
                    'nama' => $row['nama'],
                    'deskripsi' => $row['deskripsi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
