<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeLevel extends Model
{
    use HasFactory;

    protected $table = 'challenge_level';

    protected $fillable = [
        'challenge_id',
        'xp',
        'objective',
    ];

    protected $casts = [
        'xp' => 'integer',
    ];

    protected $attributes = [
        'xp' => 0,
    ];

    /**
     * Relasi ke Challenge
     */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    /**
     * Scope untuk mengurutkan level berdasarkan XP
     */
    public function scopeOrderByXp($query)
    {
        return $query->orderBy('xp', 'asc');
    }
}
