<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';

    protected $fillable = [
        'unit_id',
        'dosen_id',
        'mhs_id',
        'pertanyaan',
        'opsies',
        'answers',
        'jenis',
        'bobot',
        'xp',
        'xp_growth',
        'max_opsi',
        'emoji',
        'bg',
        'tags',
        'status',
        'approved_by_community_count',
        'reject_count',
        'durasi_jawab',
        'level_soal',
        'bs_count',
    ];

    protected $casts = [
        'bobot' => 'integer',
        'xp' => 'integer',
        'xp_growth' => 'integer',
        'max_opsi' => 'integer',
        'status' => 'integer',
        'approved_by_community_count' => 'integer',
        'reject_count' => 'integer',
        'durasi_jawab' => 'integer',
        'level_soal' => 'integer',
        'bs_count' => 'decimal:2',
    ];

    protected $attributes = [
        'bobot' => 0,
        'xp' => 100,
        'xp_growth' => 0,
        'max_opsi' => 0,
        'status' => 0,
        'approved_by_community_count' => 0,
        'reject_count' => 0,
        'durasi_jawab' => 30,
        'level_soal' => 1,
        'bs_count' => 0,
    ];

    /**
     * Relasi ke Unit
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Relasi ke Dosen (opsional)
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    /**
     * Relasi ke Mahasiswa (opsional, pembuat soal)
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mhs::class, 'mhs_id');
    }

    /**
     * Scope untuk soal aktif (status > 0)
     */
    public function scopeAktif($query)
    {
        return $query->where('status', '>', 0);
    }

    /**
     * Scope untuk filter berdasarkan level soal
     */
    public function scopeLevel($query, $level)
    {
        return $query->where('level_soal', $level);
    }

    /**
     * Scope untuk filter berdasarkan jenis soal
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }
}
