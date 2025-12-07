<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';

    protected $fillable = [
        'nama',
        'kode',
    ];

    /**
     * Relasi ke Prodi
     * Satu Fakultas memiliki banyak Prodi
     */
    public function prodi()
    {
        return $this->hasMany(Prodi::class);
    }
}
