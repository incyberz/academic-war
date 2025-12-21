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
        'tanggal_penunjukan',
        'status_peserta_bimbingan_id',
        'keterangan',
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

    public function status()
    {
        return $this->belongsTo(
            StatusPesertaBimbingan::class,
            'status_peserta_bimbingan_id'
        );
    }
}
