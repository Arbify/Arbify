<?php

namespace Arbify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    public const SUPER_ADMINISTRATOR = 3;
    public const ADMINISTRATOR = 2;
    public const USER = 1;
    public const GUEST = 0;

    protected $fillable = [
        'user_id',
        'role',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isSuperAdministrator(): bool
    {
        return $this->role === self::SUPER_ADMINISTRATOR;
    }

    public function isAdministrator(): bool
    {
        return $this->role === self::ADMINISTRATOR;
    }

    public function isUser(): bool
    {
        return $this->role === self::USER;
    }

    public function isGuest(): bool
    {
        return $this->role === self::GUEST;
    }
}
