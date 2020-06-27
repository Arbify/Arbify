<?php

namespace Arbify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use RuntimeException;

class ProjectMember extends Model
{
    public const ROLES = [
        self::ROLE_LEAD,
        self::ROLE_MEMBER,
        self::ROLE_TRANSLATOR,
    ];

    public const ROLE_LEAD = 2;
    public const ROLE_MEMBER = 1;
    public const ROLE_TRANSLATOR = 0;

    protected $fillable = [
        'user_id',
        'project_id',
        'role',
        'extra',
    ];

    protected $casts = [
        'role' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function isLead(): bool
    {
        return $this->role === self::ROLE_LEAD;
    }

    public function isMember(): bool
    {
        return $this->role === self::ROLE_MEMBER;
    }

    public function isTranslator(): bool
    {
        return $this->role === self::ROLE_TRANSLATOR;
    }

    public function allowedLanguages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class);
    }
}
