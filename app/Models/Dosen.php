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
}
