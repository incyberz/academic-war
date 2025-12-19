<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory;

    protected $table = 'pembimbing';

    protected $fillable = [
        'dosen_id',
        'nomor_surat',
        'file_surat',
        'tanggal_surat',
        'catatan',
        'is_active',
    ];

    /**
     * Relasi ke Dosen
     * Satu pembimbing pasti merujuk ke satu dosen
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
