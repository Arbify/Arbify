<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    public const VISIBILITY_PUBLIC = 0;
    public const VISIBILITY_ONLY_MEMBERS = 1;

    protected $fillable = [
        'name',
        'visibility',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function messageValues(): HasManyThrough
    {
        return $this->hasManyThrough(MessageValue::class, Message::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class)->withTimestamps();
    }

    public function projectRoles(): HasMany
    {
        return $this->hasMany(ProjectRole::class);
    }

    public function isPublic(): bool
    {
        return $this->visibility === self::VISIBILITY_PUBLIC;
    }

    public function isOnlyMembers(): bool
    {
        return $this->visibility === self::VISIBILITY_ONLY_MEMBERS;
    }
}
