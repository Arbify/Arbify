<?php

namespace Arbify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageValue extends Model
{
    protected $fillable = [
        'value',
        'form',
        'message_id',
        'language_id',
        'author_id',
        'updated_at', // Mainly for tests
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
