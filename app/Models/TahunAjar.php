<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjar extends Model
{
    protected $table = 'tahun_ajar';

    // PK berupa smallint (numeric), bukan auto increment
    protected $primaryKey = 'tahun_ajar';
    public $incrementing = false;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'tahun_ajar',
        // tambahkan field lain jika ada pada migration
    ];

    /**
     * Relasi ke tabel bimbingan
     */
    public function bimbingan(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'tahun_ajar', 'tahun_ajar');
    }
}
