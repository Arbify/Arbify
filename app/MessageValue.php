<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageValue extends Model
{
    protected $fillable = [
        'value', 'form',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
