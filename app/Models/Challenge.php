<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $table = 'challenge';

    protected $fillable = [
        'unit_id',
        'kode',
        'judul',
        'instruksi',
        'link_panduan',
        'cara_pengumpulan',
        'level',
        'xp',
        'ontime_xp',
        'ontime_at',
        'ontime_deadline',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'level' => 'integer',
        'xp' => 'integer',
        'ontime_xp' => 'integer',
        'ontime_at' => 'integer',
        'ontime_deadline' => 'integer',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * Relasi ke Unit
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Scope untuk challenge aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mengurutkan challenge
     */
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan', 'asc');
    }
}
