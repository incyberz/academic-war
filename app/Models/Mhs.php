<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mhs extends Model
{
    use HasFactory;

    protected $table = 'mhs';

    protected $fillable = [
        'user_id',
        'prodi_id',
        'nama',
        'nim',
        'angkatan',
        'status',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    /**
     * Mahasiswa bisa beberapa kali menjadi peserta bimbingan.
     * Contoh: PKL, Skripsi, KKN, dll.
     */
    public function pesertaBimbingan()
    {
        return $this->hasMany(PesertaBimbingan::class, 'mhs_id');
    }

    /**
     * Riwayat bimbingan detail (jika tabel bimbingan nanti dibuat)
     */
    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'mhs_id');
    }
}
