<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikulum';

    protected $fillable = [
        'nama',
        'tahun',
        'prodi_id',
        'is_active',
        'keterangan',
    ];

    /**
     * Relasi: Kurikulum dimiliki oleh satu Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
