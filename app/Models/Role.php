<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $table = 'role';

    protected $fillable = [
        'role_name',
        'nama',
        'deskripsi',
    ];

    /**
     * Relasi ke users (1 role dimiliki banyak user)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
