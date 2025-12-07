<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    // Karena nama tabel bukan jamak
    protected $table = 'role';

    // Primary key berupa string, bukan auto increment
    protected $primaryKey = 'role';

    // PK bertipe string
    public $incrementing = false;
    protected $keyType = 'string';

    // Kolom yang dapat diisi
    protected $fillable = [
        'role',
        'nama',
        'deskripsi',
    ];

    /**
     * Relasi ke users (1 role dimiliki banyak user)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role', 'role');
    }
}
