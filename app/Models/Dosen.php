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
     * 1 dosen dimiliki oleh 1 user (belongsTo)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Prodi
     * 1 dosen berada di 1 prodi (belongsTo)
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
