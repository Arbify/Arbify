<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

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

    public static function allExceptAlreadyInProject(Project $project)
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

//SELECT l.name language
//FROM languages l
//WHERE l.id NOT IN (
//    SELECT languages.id FROM languages
//      INNER JOIN language_project lp ON languages.id = lp.language_id
//  WHERE lp.project_id = 2
//)
