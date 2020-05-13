<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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

    private const PLURAL_FORMS = [
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

    private const GENDER_FORMS = [
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

    public function getPluralForms(): array
    {
        $forms = [];

        foreach (self::PLURAL_FORMS as $form => $mask) {
            if ($this->plural_forms & $mask) {
                $forms[] = $form;
            }
        }

        return $forms;
    }

    public function getGenderForms(): array
    {
        // AFAIK all languages support three gender forms.
        return self::GENDER_FORMS;
    }

    public static function allExceptAlreadyInProject(Project $project): Collection
    {
        return self::query()
            ->whereNotIn('id', function (Builder $query) use ($project) {
                $query
                    ->select('l2.id')
                    ->from('languages AS l2')
                    ->join('language_project AS lp', 'l2.id', '=', 'lp.language_id')
                    ->where('lp.project_id', '=', $project->id);
            })->get();
    }
}
