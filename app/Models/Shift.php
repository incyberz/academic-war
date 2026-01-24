<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shift';

    protected $fillable = [
        'kode',
        'nama',
        'jam_awal_kuliah',
        'jam_akhir_kuliah',
        'min_persen_presensi',
        'min_pembayaran',
        'keterangan',
    ];

    protected $casts = [
        'jam_awal_kuliah' => 'datetime:H:i',
        'jam_akhir_kuliah' => 'datetime:H:i',
        'min_persen_presensi' => 'integer',
        'min_pembayaran' => 'integer',
    ];

    protected $attributes = [
        'jam_awal_kuliah' => '08:00',
        'jam_akhir_kuliah' => '16:00',
        'min_persen_presensi' => 75,
        'min_pembayaran' => 50,
    ];

    /**
     * Scope untuk mencari shift berdasarkan kode
     */
    public function scopeKode($query, $kode)
    {
        return $query->where('kode', $kode);
    }

    /**
     * Scope untuk shift aktif berdasarkan jam kuliah sekarang
     */
    public function scopeAktifSekarang($query)
    {
        $now = now()->format('H:i');
        return $query->where('jam_awal_kuliah', '<=', $now)
            ->where('jam_akhir_kuliah', '>=', $now);
    }
}
