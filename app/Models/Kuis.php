<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    use HasFactory;

    protected $table = 'kuis';

    protected $fillable = [
        'unit_id',
        'judul',
        'jumlah_soal',
        'dosen_id',
        'durasi_menit',
    ];

    protected $casts = [
        'jumlah_soal' => 'integer',
        'durasi_menit' => 'integer',
    ];

    protected $attributes = [
        'jumlah_soal' => 10,
    ];

    /**
     * Relasi ke Unit
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Relasi ke Dosen pembuat
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    /**
     * Scope untuk filter kuis berdasarkan judul
     */
    public function scopeJudul($query, $judul)
    {
        return $query->where('judul', 'like', "%{$judul}%");
    }

    /**
     * Scope untuk filter kuis aktif (jumlah soal > 0)
     */
    public function scopeAktif($query)
    {
        return $query->where('jumlah_soal', '>', 0);
    }
}
