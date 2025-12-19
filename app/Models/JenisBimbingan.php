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
    ];

    /**
     * Relasi ke tabel bimbingan.
     */
    public function bimbingan(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'jenis_bimbingan_id');
    }
}
