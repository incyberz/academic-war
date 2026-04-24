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
        'is_awal',
        'is_inti',
        'is_akhir',
        'is_active',
        'deskripsi',
    ];

    protected $casts = [
        'is_awal'   => 'boolean',
        'is_inti'  => 'boolean',
        'is_akhir'  => 'boolean',
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    # ============================================================
    # RELASI
    # ============================================================
    public function subBab()
    {
        return $this->hasMany(SubBabLaporan::class, 'bab_laporan_id');
    }


    public function jenisBimbingan()
    {
        return $this->belongsTo(JenisBimbingan::class, 'jenis_bimbingan_id');
    }





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
    public function scopeInti($query)
    {
        return $query->where('is_inti', true);
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


    # ============================================================
    # HELPERS
    # ============================================================
    public function GetJumlahSubBabAttribute(): int
    {
        return $this->subBab()->count();
    }
}
