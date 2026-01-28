<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'role_id',
        'whatsapp',
        'gender',
        'avatar',
        'tempat_lahir',
        'tanggal_lahir',
        'password',
        'status',
        'avatar_verified_at',
        'whatsapp_verified_at',
        'alamat_lengkap',
        'kec_id',
        'kelengkapan_akun', // 0-100 persen
    ];

    protected $casts = [
        'tanggal_lahir'        => 'date',
        'avatar_verified_at'        => 'datetime',
        'whatsapp_verified_at'        => 'datetime',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function kec()
    {
        return $this->belongsTo(Kec::class, 'kec_id', 'id');
    }

    // Relation to Dosen
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'user_id', 'id');
    }


    public function pathAvatar()
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        // auto-null jika file tidak ada
        if ($this->avatar) {
            $this->updateQuietly(['avatar' => null]);
        }

        return asset('img/roles/mhs.png');
    }

    public function properName()
    {
        return ucwords(strtolower($this->name));
    }

    public function whatsappUI(): string
    {
        return empty($this->whatsapp) ? '-' : '628...' . substr($this->whatsapp, -3);
    }


    # ============================================================
    # USER GAMIFICATION
    # ============================================================
    public function getIsPasswordDefaultAttribute(): bool
    {
        // misal default = username
        if (!$this->password) return true;

        return Hash::check($this->username, $this->password);
    }

    public function getProfileCompletenessBonusAttribute(): int
    {
        $rules = config('xp_bonus.profile', []);

        $bonus = 0;
        foreach ($rules as $field => $rule) {
            if ($field == 'password') {
                if (!$this->is_password_default) {
                    $bonus += $rule['point'];
                }
            } else {
                if (!empty($this->$field)) {
                    $bonus += $rule['point'];
                }
            }
        }

        return $bonus;
    }

    public function getProfileCompletenessProgressAttribute(): int
    {
        $rules = config('xp_bonus.profile', []);
        $bonus = $this->profile_completeness_bonus;
        $totalBonus = 0;

        foreach ($rules as $field => $rule) {
            $totalBonus += $rule['point'];
        }

        return (int) round(($bonus / $totalBonus) * 100);
    }


    # ============================================================
    # USER GAMIFICATION METHOD
    # ============================================================
    public function cekKelengkapanAkun(): int
    {
        return 0;
    }
}
