<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertemuanTa extends Model
{
    use HasFactory;

    protected $table = 'pertemuan_ta';

    protected $fillable = [
        'mk_ta_id',
        'pertemuan_id',
        'topik',
        'catatan',
        'tags',
    ];

    /**
     * Relasi ke MK_TA
     */
    public function mkTa()
    {
        return $this->belongsTo(MkTa::class, 'mk_ta_id');
    }

    /**
     * Relasi ke master pertemuan
     */
    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'pertemuan_id');
    }

    /**
     * Scope untuk filter berdasarkan tag
     */
    public function scopeTag($query, $tag)
    {
        return $query->where('tags', 'like', "%{$tag}%");
    }

    /**
     * Scope untuk filter berdasarkan topik
     */
    public function scopeTopik($query, $topik)
    {
        return $query->where('topik', 'like', "%{$topik}%");
    }
}
