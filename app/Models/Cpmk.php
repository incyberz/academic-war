<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
    use HasFactory;

    protected $table = 'cpmk';

    protected $fillable = [
        'kode',
        'deskripsi',
        'cpl_id',
        'mk_id',
    ];

    /**
     * Relasi: CPMK → CPL
     */
    public function cpl()
    {
        return $this->belongsTo(Cpl::class);
    }

    /**
     * Relasi: CPMK → Mata Kuliah
     */
    public function mk()
    {
        return $this->belongsTo(Mk::class);
    }
}
