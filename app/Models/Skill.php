<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    protected $table = 'skill';

    protected $fillable = [
        'bootcamp_id',
        'nama',
        'deskripsi',
        'urutan',
        'xp',
    ];

    public function bootcamp(): BelongsTo
    {
        return $this->belongsTo(Bootcamp::class);
    }

    public function mission(): HasMany
    {
        return $this->hasMany(Mission::class);
    }
}
