<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesertaBimbingan extends Model
{
    use HasFactory;

    protected $table = 'peserta_bimbingan';

    protected $fillable = [
        'mhs_id',
        'bimbingan_id',
        'ditunjuk_oleh',
        'status',
        'keterangan',
        'progress',
        'terakhir_topik',
        'terakhir_bimbingan',
        'terakhir_reviewed',
    ];

    /**
     * Relasi ke Mahasiswa (mhs)
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mhs::class, 'mhs_id');
    }

    /**
     * Relasi ke User yang menunjuk mahasiswa sebagai peserta bimbingan
     */
    public function penunjuk()
    {
        return $this->belongsTo(User::class, 'ditunjuk_oleh');
    }

    public function bimbingan()
    {
        return $this->belongsTo(
            Bimbingan::class,
            'bimbingan_id'
        );
    }
}
