<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BabLaporan extends Model
{
    use HasFactory;

    protected $table = 'bab_laporan';

    protected $fillable = [
        'jenis_bimbingan_id',
        'kode',
        'nama',
        'urutan',
        'is_inti',
        'deskripsi',
    ];

    protected $casts = [
        'is_awal'   => 'boolean',
        'is_utama'  => 'boolean',
        'is_akhir'  => 'boolean',
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    */

    /** hanya bab aktif */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** bab awal (tata tulis awal) */
    public function scopeAwal($query)
    {
        return $query->where('is_awal', true);
    }

    /** bab utama (BAB I–V) */
    public function scopeUtama($query)
    {
        return $query->where('is_utama', true);
    }

    /** bab akhir */
    public function scopeAkhir($query)
    {
        return $query->where('is_akhir', true);
    }

    /** urut default */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}
