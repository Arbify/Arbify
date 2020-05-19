<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectRole extends Model
{
    public const LEAD = 2;
    public const MEMBER = 1;
    public const TRANSLATOR = 0;

    protected $fillable = [
        'user_id',
        'project_id',
        'role',
        'extra',
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
        return $this->role === self::LEAD;
    }

    public function isMember(): bool
    {
        return $this->role === self::MEMBER;
    }

    public function isTranslator(): bool
    {
        return $this->role === self::TRANSLATOR;
    }
}
