<?php

namespace Arbify\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public const PLURAL_FORM_ZERO  = 'zero';
    public const PLURAL_FORM_ONE   = 'one';
    public const PLURAL_FORM_TWO   = 'two';
    public const PLURAL_FORM_FEW   = 'few';
    public const PLURAL_FORM_MANY  = 'many';
    public const PLURAL_FORM_OTHER = 'other';

    public const PLURAL_FORMS = [
        self::PLURAL_FORM_ZERO  => 0b000001,
        self::PLURAL_FORM_ONE   => 0b000010,
        self::PLURAL_FORM_TWO   => 0b000100,
        self::PLURAL_FORM_FEW   => 0b001000,
        self::PLURAL_FORM_MANY  => 0b010000,
        self::PLURAL_FORM_OTHER => 0b100000,
    ];

    public const GENDER_FORM_MALE   = 'male';
    public const GENDER_FORM_FEMALE = 'female';
    public const GENDER_FORM_OTHER  = 'other';

    public const GENDER_FORMS = [
        self::GENDER_FORM_MALE,
        self::GENDER_FORM_FEMALE,
        self::GENDER_FORM_OTHER,
    ];

    protected $fillable = [
        'name',
        'code',
        'flag',
        'plural_forms',
    ];

    protected $appends = ['gender_forms'];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function getDisplayName(): string
    {
        if ($this->name === null) {
            return $this->code;
        }

        return "$this->code - $this->name";
    }

    public function getPluralFormsAttribute($pluralForms): array
    {
        $forms = [];

        foreach (self::PLURAL_FORMS as $form => $mask) {
            if ($pluralForms & $mask) {
                $forms[] = $form;
            }
        }

        return $forms;
    }

    public function setPluralFormsAttribute($value): void
    {
        if (!is_array($value)) {
            throw new \InvalidArgumentException('Plural forms must be an array.');
        }

        $pluralForms = 0;
        foreach ($value as $form) {
            if (!in_array($form, array_keys(self::PLURAL_FORMS))) {
                throw new \InvalidArgumentException("There's no $form plural form.");
            }

            $pluralForms |= self::PLURAL_FORMS[$form];
        }

        $this->attributes['plural_forms'] = $pluralForms;
    }

    public function getGenderFormsAttribute(): array
    {
        // AFAIK all languages support three gender forms.
        return self::GENDER_FORMS;
    }
}
