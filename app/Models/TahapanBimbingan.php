<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahapanBimbingan extends Model
{
    use HasFactory;

    protected $table = 'tahapan_bimbingan';

    protected $fillable = [
        'jenis_bimbingan_id',
        'nama_tahapan',
        'urutan',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function jenisBimbingan()
    {
        return $this->belongsTo(JenisBimbingan::class, 'jenis_bimbingan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUrut($query)
    {
        return $query->orderBy('urutan');
    }
}
