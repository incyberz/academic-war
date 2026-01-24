<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $table = 'pertemuan';

    protected $fillable = [
        'mk_id',
        'urutan',
        'judul',
        'materi',
        'tags',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    /**
     * Relasi ke Mata Kuliah (MK)
     */
    public function mk()
    {
        return $this->belongsTo(Mk::class);
    }

    /**
     * Scope untuk mengurutkan pertemuan
     */
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    /**
     * Scope untuk mencari berdasarkan tag
     */
    public function scopeTag($query, $tag)
    {
        return $query->where('tags', 'like', "%{$tag}%");
    }
}
