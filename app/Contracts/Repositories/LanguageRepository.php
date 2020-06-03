<?php

declare(strict_types=1);

namespace Arbify\Contracts\Repositories;

use Arbify\Models\Language;
use Arbify\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface LanguageRepository
{
    public function byId(int $id): Language;

    public function byIds(array $ids): Collection;

    public function byCode(string $code): Language;

    public function all(): Collection;

    public function allPaginated(): LengthAwarePaginator;

    public function allInProject(Project $project): Collection;

    public function allExceptAlreadyInProject(Project $project): Collection;
}
