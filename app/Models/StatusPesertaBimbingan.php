<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusPesertaBimbingan extends Model
{
    use HasFactory;

    protected $table = 'status_peserta_bimbingan';

    protected $fillable = [
        'nama',
        'kode',
        'warna',
        'keterangan',
    ];

    /**
     * Relasi ke peserta bimbingan
     * One status → banyak peserta
     */
    public function pesertaBimbingan()
    {
        return $this->hasMany(
            PesertaBimbingan::class,
            'status_peserta_bimbingan_id'
        );
    }
}
