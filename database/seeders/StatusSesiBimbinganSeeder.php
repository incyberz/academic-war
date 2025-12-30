<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSesiBimbinganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('status_sesi_bimbingan')->insert([
            [
                'id' => -2,
                'nama_status' => 'Ditolak',
                'keterangan' => 'Laporan tidak disetujui dan perlu perbaikan total',
                'bg' => 'danger',
            ],
            [
                'id' => -1,
                'nama_status' => 'Revisi',
                'keterangan' => 'Dosen memberikan revisi pada laporan',
                'bg' => 'danger',
            ],
            [
                'id' => 0,
                'nama_status' => 'Draft',
                'keterangan' => 'Laporan baru dibuat oleh mahasiswa, belum dikirim ke dosen',
                'bg' => 'info',
            ],
            [
                'id' => 1,
                'nama_status' => 'Diajukan',
                'keterangan' => 'Laporan sudah dikirim ke dosen pembimbing',
                'bg' => 'warning',
            ],
            [
                'id' => 2,
                'nama_status' => 'Revised',
                'keterangan' => 'Direvisi oleh file laporan baru',
                'bg' => 'success',
            ],
            [
                'id' => 3,
                'nama_status' => 'Disetujui',
                'keterangan' => 'Dosen menyetujui laporan tanpa revisi (untuk saat ini)',
                'bg' => 'success',
            ],
            [
                'id' => 4,
                'nama_status' => 'Disahkan',
                'keterangan' => 'Laporan final sudah disetujui dan tidak boleh ada revisi lagi',
                'bg' => 'success',
            ],
        ]);
    }
}
