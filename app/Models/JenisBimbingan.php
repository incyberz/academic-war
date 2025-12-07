<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisBimbingan extends Model
{
    protected $table = 'jenis_bimbingan';

    // PK berupa string
    protected $primaryKey = 'jenis_bimbingan';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'jenis_bimbingan',
        'nama',       // jika Anda menambahkan field deskriptif, opsional
        'deskripsi',  // opsional
    ];

    /**
     * Relasi ke tabel bimbingan.
     */
    public function bimbingan(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'jenis_bimbingan', 'jenis_bimbingan');
    }
}
