<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Language;
use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface LanguageRepository
{
    public function byId(int $id): Language;

    public function byCode(string $code): Language;

    public function paginated(): LengthAwarePaginator;

    public function allInProject(Project $project): Collection;

    public function allExceptAlreadyInProject(Project $project): Collection;
}
