<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiBimbingan extends Model
{
    use HasFactory;

    /**
     * Nama tabel (karena bukan plural default Laravel)
     */
    protected $table = 'sesi_bimbingan';

    /**
     * Mass assignable
     */
    protected $fillable = [
        'peserta_bimbingan_id',
        'status_sesi_bimbingan',
        'tahapan_bimbingan_id',
        'topik',
        'pesan_mhs',
        'pesan_dosen',
        'file_bimbingan',
        'file_review',
        'tanggal_review',
    ];

    /**
     * Casting field
     */
    protected $casts = [
        'tanggal_review' => 'datetime',
    ];

    /* ======================
     * RELATIONS
     * ====================== */

    /**
     * Relasi ke PesertaBimbingan
     */
    public function pesertaBimbingan()
    {
        return $this->belongsTo(
            PesertaBimbingan::class,
            'peserta_bimbingan_id'
        );
    }
}
