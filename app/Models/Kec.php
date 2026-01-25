<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kec extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'kec';

    // Primary key adalah char, bukan auto-increment
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Fillable fields
    protected $fillable = [
        'id',
        'nama_kec',
        'nama_kab',
        'is_baru',
    ];
}
