<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurMk extends Model
{
    use HasFactory;

    protected $table = 'kur_mk';

    protected $fillable = [
        'kurikulum_id',
        'mk_id',
        'semester',
        'jenis',
        'prasyarat_mk_id',
    ];

    /**
     * Relasi: KurMk → Kurikulum
     */
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }

    /**
     * Relasi: KurMk → Mata Kuliah
     */
    public function mk()
    {
        return $this->belongsTo(Mk::class);
    }

    /**
     * Relasi: MK prasyarat
     */
    public function prasyaratMk()
    {
        return $this->belongsTo(Mk::class, 'prasyarat_mk_id');
    }
}
