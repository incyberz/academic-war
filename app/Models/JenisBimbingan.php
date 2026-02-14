<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisBimbingan extends Model
{
    protected $table = 'jenis_bimbingan';

    protected $fillable = [
        'kode',
        'nama',       // jika Anda menambahkan field deskriptif, opsional
        'deskripsi',  // opsional
        'status',
    ];

    /**
     * Relasi ke tabel bimbingan.
     */
    public function bimbingan(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'jenis_bimbingan_id');
    }

    public function babLaporan(): HasMany
    {
        return $this->hasMany(BabLaporan::class, 'jenis_bimbingan_id');
    }

    # ============================================================
    # HELPER ATTRIBUTE
    # ============================================================
    public function getJumlahBabLaporanAttribute(): int
    {
        return $this->babLaporan()->count();
    }
}
