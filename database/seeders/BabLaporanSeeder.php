<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BabLaporanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bab_laporan')->insert([

            // ======================
            // BAGIAN AWAL (TATA TULIS)
            // ======================

            [
                'kode' => 'COVER',
                'nama' => 'Sampul / Cover',
                'deskripsi' => 'Halaman sampul sesuai pedoman penulisan skripsi.',
                'is_inti' => false,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'JUDUL',
                'nama' => 'Halaman Judul',
                'deskripsi' => 'Halaman judul skripsi resmi.',
                'is_inti' => false,
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PENGESAHAN',
                'nama' => 'Lembar Pengesahan',
                'deskripsi' => 'Lembar pengesahan dosen pembimbing dan penguji.',
                'is_inti' => false,
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'ORISINALITAS',
                'nama' => 'Pernyataan Keaslian',
                'deskripsi' => 'Pernyataan keaslian karya ilmiah oleh mahasiswa.',
                'is_inti' => false,
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'ABS',
                'nama' => 'Abstrak',
                'deskripsi' => 'Ringkasan penelitian dalam bahasa Indonesia.',
                'is_inti' => false,
                'urutan' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'ABSTRACT',
                'nama' => 'Abstract',
                'deskripsi' => 'Ringkasan penelitian dalam bahasa Inggris.',
                'is_inti' => false,
                'urutan' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PRAKATA',
                'nama' => 'Kata Pengantar',
                'deskripsi' => 'Ucapan terima kasih dan pengantar penulisan skripsi.',
                'is_inti' => false,
                'urutan' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'DAFTAR_ISI',
                'nama' => 'Daftar Isi',
                'deskripsi' => 'Daftar isi seluruh bagian skripsi.',
                'is_inti' => false,
                'urutan' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'DAFTAR_TABEL',
                'nama' => 'Daftar Tabel',
                'deskripsi' => 'Daftar tabel yang digunakan dalam skripsi.',
                'is_inti' => false,
                'urutan' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'DAFTAR_GAMBAR',
                'nama' => 'Daftar Gambar',
                'deskripsi' => 'Daftar gambar atau diagram dalam skripsi.',
                'is_inti' => false,
                'urutan' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'DAFTAR_LAMPIRAN',
                'nama' => 'Daftar Lampiran',
                'deskripsi' => 'Daftar dokumen lampiran.',
                'is_inti' => false,
                'urutan' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ======================
            // BAB INTI
            // ======================

            [
                'kode' => 'BAB I',
                'nama' => 'Pendahuluan',
                'deskripsi' => 'Latar belakang, rumusan masalah, tujuan, manfaat, dan sistematika penulisan.',
                'is_inti' => true,
                'urutan' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'BAB II',
                'nama' => 'Tinjauan Pustaka',
                'deskripsi' => 'Penelitian terkait, landasan teori, dan kerangka pemikiran.',
                'is_inti' => true,
                'urutan' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'BAB III',
                'nama' => 'Metodologi Penelitian',
                'deskripsi' => 'Metode penelitian dan teknik analisis data.',
                'is_inti' => true,
                'urutan' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'BAB IV',
                'nama' => 'Hasil dan Pembahasan',
                'deskripsi' => 'Hasil penelitian dan pembahasan.',
                'is_inti' => true,
                'urutan' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'BAB V',
                'nama' => 'Penutup',
                'deskripsi' => 'Kesimpulan dan saran.',
                'is_inti' => true,
                'urutan' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ======================
            // BAGIAN AKHIR
            // ======================

            [
                'kode' => 'DP',
                'nama' => 'Daftar Pustaka',
                'deskripsi' => 'Referensi yang digunakan dalam penelitian.',
                'is_inti' => false,
                'urutan' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'LAMP',
                'nama' => 'Lampiran',
                'deskripsi' => 'Dokumen pendukung penelitian.',
                'is_inti' => false,
                'urutan' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
