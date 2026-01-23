<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusAkademik extends Model
{
    use HasFactory;

    protected $table = 'status_akademik';

    protected $fillable = [
        'kode',
        'nama',
        'keterangan',
        'boleh_krs',
        'boleh_kuliah',
        'boleh_login',
    ];

    protected $casts = [
        'boleh_krs' => 'boolean',
        'boleh_kuliah' => 'boolean',
        'boleh_login' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    public function mhs()
    {
        return $this->hasMany(Mhs::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper / Scope
    |--------------------------------------------------------------------------
    */

    public function isAktif(): bool
    {
        return $this->kode === 'AKTIF';
    }

    public function isCuti(): bool
    {
        return $this->kode === 'CUTI';
    }

    public function isTerminal(): bool
    {
        return in_array($this->kode, ['LULUS', 'DO']);
    }

    /*
    |--------------------------------------------------------------------------
    | Static Helper (AMAN & EKSPRESIF)
    |--------------------------------------------------------------------------
    */

    public static function aktifId(): int
    {
        return 1;
    }

    public static function cutiId(): int
    {
        return 2;
    }

    public static function nonAktifId(): int
    {
        return 3;
    }

    public static function lulusId(): int
    {
        return 4;
    }

    public static function doId(): int
    {
        return 5;
    }
}
