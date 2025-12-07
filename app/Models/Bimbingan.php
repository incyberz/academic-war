<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bimbingan extends Model
{
    protected $table = 'bimbingan';

    protected $fillable = [
        'pembimbing_id',
        'peserta_bimbingan_id',
        'jenis_bimbingan',
        'tahun_ajar',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tahun_ajar' => 'integer',
    ];

    /**
     * Relasi ke Pembimbing.
     */
    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(Pembimbing::class, 'pembimbing_id');
    }

    /**
     * Relasi ke Peserta Bimbingan.
     */
    public function pesertaBimbingan(): BelongsTo
    {
        return $this->belongsTo(PesertaBimbingan::class, 'peserta_bimbingan_id');
    }

    /**
     * Relasi ke Jenis Bimbingan.
     * PK di tabel jenis_bimbingan berupa string (pkl, skripsi, kkn).
     */
    public function jenisBimbingan(): BelongsTo
    {
        return $this->belongsTo(JenisBimbingan::class, 'jenis_bimbingan', 'jenis_bimbingan');
    }

    /**
     * Relasi ke Tahun Ajar.
     * PK di tabel tahun_ajar berupa smallint.
     */
    public function tahunAjar(): BelongsTo
    {
        return $this->belongsTo(TahunAjar::class, 'tahun_ajar', 'tahun_ajar');
    }
}
