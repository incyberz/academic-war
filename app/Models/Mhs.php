<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mhs extends Model
{
    use HasFactory;

    protected $table = 'mhs';

    protected $fillable = [
        'user_id',
        'prodi_id',
        'nama',
        'nim',
        'angkatan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi', 'prodi');
    }

    public function pesertaBimbingan()
    {
        return $this->hasMany(PesertaBimbingan::class, 'mhs_id');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'mhs_id');
    }
}
