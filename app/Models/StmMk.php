<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmMk extends Model
{
    use HasFactory;

    protected $table = 'stm_mk';

    protected $fillable = [
        'stm_id',
        'mk_id',
        'semester',
        'sks_mk',
        'sks_tugas',
        'sks_beban',
        'sks_honor',
        'catatan',
    ];

    /**
     * Relasi: Detail → STM induk
     */
    public function stm()
    {
        return $this->belongsTo(Stm::class);
    }

    /**
     * Relasi: Detail → Mata Kuliah
     */
    public function mk()
    {
        return $this->belongsTo(Mk::class);
    }
}
