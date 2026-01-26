<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjar extends Model
{
    protected $table = 'tahun_ajar';

    /**
     * Primary key bukan auto increment
     */
    public $incrementing = false;

    /**
     * Tipe primary key
     */
    protected $keyType = 'int';

    protected $fillable = [
        'id',               // ⬅️ WAJIB agar bisa mass assign
        'is_active',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    /**
     * Relasi ke tabel bimbingan
     */
    public function bimbingan(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'tahun_ajar_id', 'id');
    }
}
