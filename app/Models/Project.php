<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    protected $fillable = [
        'name',
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
}
