<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BabLaporan;
use App\Models\SubBabLaporan;

class SubBabLaporanSeeder extends Seeder
{
    public function run(): void
    {
        $jenisList = config('jenis_bimbingan');

        // template subbab per kode bab
        $template = [

            'bab1' => [
                '1.1' => 'Latar Belakang Masalah',
                '1.2' => 'Rumusan Masalah',
                '1.3' => 'Tujuan Penelitian',
                '1.4' => 'Kegunaan Penelitian',
                '1.5' => 'Metodologi dan Sistematika Penulisan',
            ],

            'bab2' => [
                '2.1' => 'Sistem Informasi',
                '2.2' => 'Perangkat Pengembangan Sistem',
                '2.3' => 'Teori Pendukung',
                '2.4' => 'Penelitian Terdahulu',
            ],

            'bab3' => [
                '3.1' => 'Struktur Organisasi',
                '3.2' => 'Analisis Kebutuhan Sistem',
                '3.3' => 'Prosedur Kerja',
                '3.4' => 'Deskripsi Dokumen',
                '3.5' => 'Identifikasi Kebutuhan Informasi',
                '3.6' => 'Analisa Kebutuhan Perangkat Lunak',
                '3.7' => 'Deskripsi Kebutuhan Fungsional (Tabel)',
                '3.8' => 'Pemodelan Kebutuhan Fungsional (Usecase)',
                '3.9' => 'Class Diagram',
            ],

        ];

        foreach ($jenisList as $jenis) {

            // ambil bab inti berdasarkan jenis
            $babList = BabLaporan::where('jenis_bimbingan_id', $jenis['id'])
                ->where('is_inti', true)
                ->get()
                ->keyBy('kode'); // penting: akses via bab1, bab2

            foreach ($template as $kodeBab => $subBabList) {

                // skip kalau bab tidak ada
                if (!isset($babList[$kodeBab])) {
                    continue;
                }

                $bab = $babList[$kodeBab];

                $urutan = 1;

                foreach ($subBabList as $kode => $nama) {

                    SubBabLaporan::updateOrCreate(
                        [
                            'bab_laporan_id' => $bab->id,
                            'kode'           => $kode,
                        ],
                        [
                            'nama'            => $nama,
                            'urutan'          => $urutan++,
                            'deskripsi'       => null,

                            // default Academic War
                            'poin'            => 10,
                            'is_wajib'        => true,
                            'petunjuk_bukti'  => "Upload foto bukti pengerjaan: {$nama}",
                            'contoh_bukti'    => null,
                            'can_revisi'      => true,
                            'is_active'       => true,
                            'is_locked'       => false,
                        ]
                    );
                }
            }
        }
    }
}
