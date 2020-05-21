<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\LanguageRepository as LanguageRepositoryContract;
use App\Models\Language;
use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LanguageRepository implements LanguageRepositoryContract
{
    public function byId(int $id): Language
    {
        return Language::findOrFail($id);
    }

    public function byCode(string $code): Language
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Language::where('code', $code)->firstOrFail();
    }

    public function allPaginated(): LengthAwarePaginator
    {
        return Language::orderBy('code')->paginate(30);
    }

    public function allInProject(Project $project): Collection
    {
        return $project->languages()->get();
    }

    public function allExceptAlreadyInProject(Project $project): Collection
    {
        $usedIds = $project->languages()->allRelatedIds();

        return Language::query()->whereNotIn('id', $usedIds)->get();
    }
}
