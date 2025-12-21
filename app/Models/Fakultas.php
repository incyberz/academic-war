<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    // Nama tabel
    protected $table = 'fakultas';

    // Field yang boleh diisi
    protected $fillable = [
        'kode',
        'urutan',
        'nama',

        'batas_telat_bimbingan', // 14
        'batas_review_dosen', // 7
        'batas_kritis_bimbingan', // 30
        'jam_awal_bimbingan', // 08:00
        'jam_akhir_bimbingan', // 21:00
        'max_bimbingan_per_minggu', // 2
        'max_peserta_per_dosen', // 10
        'max_durasi_menit_bimbingan', // 60
        'max_bulan_masa_bimbingan', // 12

    ];
}
