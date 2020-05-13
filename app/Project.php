<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class)->withTimestamps();
    }
}
