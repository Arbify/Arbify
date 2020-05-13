<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    const PLURAL_FORM_ZERO = 0b000001;
    const PLURAL_FORM_ONE = 0b000010;
    const PLURAL_FORM_TWO = 0b000100;
    const PLURAL_FORM_FEW = 0b001000;
    const PLURAL_FORM_MANY = 0b010000;
    const PLURAL_FORM_OTHER = 0b100000;

    protected $fillable = [
        'name', 'code', 'flag', 'plural_forms',
    ];

    public function getPluralForms()
    {
        return $this->plural_forms;
    }
}
