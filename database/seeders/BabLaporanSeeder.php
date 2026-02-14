<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BabLaporanSeeder extends Seeder
{
    public function run(): void
    {
        $arrJenisBimbinganId = [1, 2, 3];
        foreach ($arrJenisBimbinganId as $jenisBimbinganId) {
            DB::table('bab_laporan')->insert([

                // ======================
                // BAGIAN AWAL (TATA TULIS)
                // ======================

                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'cover',
                    'nama' => 'Sampul / Cover',
                    'deskripsi' => 'Halaman sampul sesuai pedoman penulisan skripsi.',
                    'is_inti' => false,
                    'urutan' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'hal_judul',
                    'nama' => 'Halaman Judul',
                    'deskripsi' => 'Halaman judul skripsi resmi.',
                    'is_inti' => false,
                    'urutan' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'pengesahan',
                    'nama' => 'Lembar Pengesahan',
                    'deskripsi' => 'Lembar pengesahan dosen pembimbing dan penguji.',
                    'is_inti' => false,
                    'urutan' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'hal_ori',
                    'nama' => 'Pernyataan Keaslian',
                    'deskripsi' => 'Pernyataan keaslian karya ilmiah oleh mhs.',
                    'is_inti' => false,
                    'urutan' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'abstrak',
                    'nama' => 'Abstrak',
                    'deskripsi' => 'Ringkasan penelitian dalam bahasa Indonesia.',
                    'is_inti' => false,
                    'urutan' => 5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'abstract',
                    'nama' => 'Abstract',
                    'deskripsi' => 'Ringkasan penelitian dalam bahasa Inggris.',
                    'is_inti' => false,
                    'urutan' => 6,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'prakata',
                    'nama' => 'Kata Pengantar',
                    'deskripsi' => 'Ucapan terima kasih dan pengantar penulisan skripsi.',
                    'is_inti' => false,
                    'urutan' => 7,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'daftar_isi',
                    'nama' => 'Daftar Isi',
                    'deskripsi' => 'Daftar isi seluruh bagian skripsi.',
                    'is_inti' => false,
                    'urutan' => 8,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'daftar_tbl',
                    'nama' => 'Daftar Tabel',
                    'deskripsi' => 'Daftar tabel yang digunakan dalam skripsi.',
                    'is_inti' => false,
                    'urutan' => 9,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'daftar_gbr',
                    'nama' => 'Daftar Gambar',
                    'deskripsi' => 'Daftar gambar atau diagram dalam skripsi.',
                    'is_inti' => false,
                    'urutan' => 10,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'daftar_lam',
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
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'bab1',
                    'nama' => 'Bab 1 Pendahuluan',
                    'deskripsi' => 'Latar belakang, rumusan masalah, tujuan, manfaat, dan sistematika penulisan.',
                    'is_inti' => true,
                    'urutan' => 12,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'bab2',
                    'nama' => 'Bab 2 Tinjauan Pustaka',
                    'deskripsi' => 'Penelitian terkait, landasan teori, dan kerangka pemikiran.',
                    'is_inti' => true,
                    'urutan' => 13,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'bab3',
                    'nama' => 'Bab 3 Metodologi Penelitian',
                    'deskripsi' => 'Metode penelitian dan teknik analisis data.',
                    'is_inti' => true,
                    'urutan' => 14,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'bab4',
                    'nama' => 'Bab 4 Hasil dan Pembahasan',
                    'deskripsi' => 'Hasil penelitian dan pembahasan.',
                    'is_inti' => true,
                    'urutan' => 15,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'bab5',
                    'nama' => 'Bab 5 Penutup',
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
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'daftar_pus',
                    'nama' => 'Daftar Pustaka',
                    'deskripsi' => 'Referensi yang digunakan dalam penelitian.',
                    'is_inti' => false,
                    'urutan' => 17,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'jenis_bimbingan_id' => $jenisBimbinganId,
                    'kode' => 'lampiran',
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
}
