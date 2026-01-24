<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanMhs extends Model
{
    use HasFactory;

    protected $table = 'jawaban_mhs';

    protected $fillable = [
        'kuis_id',
        'soal_id',
        'pembuat_id',
        'penjawab_id',
        'jawaban',
        'is_benar',
        'xp_penjawab',
        'xp_pembuat',
        'apresiasi_xp',
        'status',
    ];

    protected $casts = [
        'is_benar' => 'boolean',
        'xp_penjawab' => 'integer',
        'xp_pembuat' => 'integer',
        'apresiasi_xp' => 'integer',
        'status' => 'integer',
    ];

    protected $attributes = [
        'xp_penjawab' => 0,
        'xp_pembuat' => 0,
        'apresiasi_xp' => 0,
        'status' => 0,
    ];

    /**
     * Relasi ke Kuis
     */
    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }

    /**
     * Relasi ke Soal
     */
    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    /**
     * Relasi ke pembuat soal (kelas_mhs)
     */
    public function pembuat()
    {
        return $this->belongsTo(KelasMhs::class, 'pembuat_id');
    }

    /**
     * Relasi ke penjawab soal (kelas_mhs)
     */
    public function penjawab()
    {
        return $this->belongsTo(KelasMhs::class, 'penjawab_id');
    }

    /**
     * Scope untuk jawaban yang benar
     */
    public function scopeBenar($query)
    {
        return $query->where('is_benar', true);
    }

    /**
     * Scope untuk jawaban yang salah
     */
    public function scopeSalah($query)
    {
        return $query->where('is_benar', false);
    }

    /**
     * Scope untuk filter status approval
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
