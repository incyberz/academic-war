<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bootcamp extends Model
{
    protected $table = 'bootcamp';

    protected $fillable = [
        'nama',
        'deskripsi',
        'status',
        'xp_total',
    ];

    public function skill(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
}
