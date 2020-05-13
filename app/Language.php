<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public const PLURAL_FORM_ZERO  = 0b000001;
    public const PLURAL_FORM_ONE   = 0b000010;
    public const PLURAL_FORM_TWO   = 0b000100;
    public const PLURAL_FORM_FEW   = 0b001000;
    public const PLURAL_FORM_MANY  = 0b010000;
    public const PLURAL_FORM_OTHER = 0b100000;

    protected $fillable = [
        'name', 'code', 'flag', 'plural_forms',
    ];

    public function getPluralForms(): int
    {
        return $this->plural_forms;
    }

    public static function allExceptAlreadyInProject(Project $project): Collection
    {
        return self::query()
            ->whereNotIn('id', function (Builder $query) use ($project) {
                $query
                    ->select('l2.id')
                    ->from('languages AS l2')
                    ->join('language_project AS lp','l2.id', '=', 'lp.language_id')
                    ->where('lp.project_id', '=', $project->id);
            })->get();
    }
}
