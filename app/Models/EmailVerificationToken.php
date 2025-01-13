<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailVerificationToken extends Model
{
    use HasUuids;

    protected $table = 'email_verification_tokens';

    protected $fillable = [
        'id',
        'token',
        'user_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($token) {
            $token->token = Str::uuid();
            $token->expires_at = now()->addHours(24);
        });
    }

    /**
     * Check if the token has expired.
     *
     * @return bool True if the token has expired, false otherwise.
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
