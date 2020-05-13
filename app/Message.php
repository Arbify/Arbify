<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description',
    ];

    public function project()
    {
        $this->belongsTo(Project::class);
    }
}
