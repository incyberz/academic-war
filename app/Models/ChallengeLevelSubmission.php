<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeLevelSubmission extends Model
{
    use HasFactory;

    protected $table = 'challenge_level_submission';

    protected $fillable = [
        'challenge_submission_id',
        'challenge_level_id',
        'bukti',
        'catatan',
        'is_approved',
        'feedback',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Relasi ke ChallengeSubmission
     */
    public function submission()
    {
        return $this->belongsTo(ChallengeSubmission::class, 'challenge_submission_id');
    }

    /**
     * Relasi ke ChallengeLevel
     */
    public function level()
    {
        return $this->belongsTo(ChallengeLevel::class, 'challenge_level_id');
    }

    /**
     * Scope untuk level yang sudah disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope untuk level yang belum disetujui
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false)->orWhereNull('is_approved');
    }
}
