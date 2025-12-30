<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahapanBimbinganSeeder extends Seeder
{
    public function run(): void
    {
        $tahapan = [
            'Eligible Bimbingan',
            'Sudah Pengajuan Judul',
            'Penunjukan Dosen Pembimbing',
            'Judul Disetujui Pembimbing',
            'Bab 1 Selesai',
            'Bab 2 Selesai',
            'Bab 3 Selesai',
            'Acc Seminar',
            'Seminar Selesai',
            'Revisi Seminar Selesai',
            'Pengambilan Data Selesai',
            'Bab 4 Selesai',
            'Development Selesai',
            'Pengujian Sistem Selesai',
            'Bab 5 Selesai',
            'Acc Siap Sidang',
            'Sudah Pendaftaran Sidang',
            'Penguji Sudah Ditetapkan',
            'Sidang Selesai',
            'Revisi Sidang Selesai',
            'Revisi Program Selesai',
            'Upload Final',
            'Pengesahan Fakultas',
            'Yudisium',
        ];

        $jenisBimbinganIds = [1, 3];

        foreach ($jenisBimbinganIds as $jenisId) {

            foreach ($tahapan as $index => $namaTahap) {

                DB::table('tahapan_bimbingan')->insert([
                    'jenis_bimbingan_id' => $jenisId,
                    'urutan'             => $index + 1,
                    'tahap'              => $namaTahap,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }
        }
    }
}
