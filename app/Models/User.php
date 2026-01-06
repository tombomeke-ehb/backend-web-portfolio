<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'birthday',
        'about',
        'preferred_language',
        'profile_photo_path',
        'is_admin',
        'password',
        'public_profile',
        'email_notifications',
        'timezone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birthday' => 'date',
            'is_admin' => 'boolean',
            'password' => 'hashed',
            'public_profile' => 'boolean',
            'email_notifications' => 'boolean',
        ];
    }

    public function skills()
    {
        return $this->hasMany(\App\Models\UserSkill::class);
    }

    /**
     * Generate a unique username based on the user's name.
     * Falls back to "newuserX" where X is incrementing if name-based username fails.
     */
    public static function generateUsername(string $name): string
    {
        // First attempt: sanitize name and use as base
        $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));

        // If name is empty or too short after sanitization, use fallback
        if (strlen($baseUsername) < 3) {
            return self::generateFallbackUsername();
        }

        // Try the base username
        if (!self::where('username', $baseUsername)->exists()) {
            return $baseUsername;
        }

        // Try with numbers 1-99
        for ($i = 1; $i <= 99; $i++) {
            $username = $baseUsername . $i;
            if (!self::where('username', $username)->exists()) {
                return $username;
            }
        }

        // If all fail, use fallback
        return self::generateFallbackUsername();
    }

    /**
     * Generate a fallback username like "newuser1", "newuser2", etc.
     */
    private static function generateFallbackUsername(): string
    {
        // Find the highest newuser number
        $lastUser = self::where('username', 'like', 'newuser%')
            ->orderByRaw('CAST(SUBSTRING(username, 8) AS UNSIGNED) DESC')
            ->first();

        if ($lastUser && preg_match('/newuser(\d+)/', $lastUser->username, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        // Keep trying until we find an available one
        while (self::where('username', 'newuser' . $nextNumber)->exists()) {
            $nextNumber++;
        }

        return 'newuser' . $nextNumber;
    }
}
