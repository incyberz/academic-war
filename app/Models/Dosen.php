<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    // Nama tabel (opsional, karena default = plural)
    protected $table = 'dosen';

    // Kolom yang boleh diisi
    protected $fillable = [
        'nama',
        'user_id',
        'prodi_id',
        'nidn',
        'gelar_depan',
        'gelar_belakang',
        'jabatan_fungsional',
    ];

    public function namaGelar(): string
    {
        $nama = trim($this->nama);
        $hasil = '';

        // Gelar depan
        if (!empty($this->gelar_depan)) {
            $gelarDepan = trim($this->gelar_depan);

            // Tambahkan titik jika belum ada
            if (!str_ends_with($gelarDepan, '.')) {
                $gelarDepan .= '.';
            }

            $hasil .= $gelarDepan . ' ';
        }

        // Nama wajib
        $hasil .= $nama;

        // Gelar belakang
        if (!empty($this->gelar_belakang)) {
            $hasil .= ', ' . trim($this->gelar_belakang);
        }

        return trim($hasil);
    }


    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }


    /**
     * Relasi ke Pembimbing
     */
    public function pembimbing()
    {
        return $this->hasOne(Pembimbing::class, 'dosen_id');
    }
}
