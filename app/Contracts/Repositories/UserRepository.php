<?php

declare(strict_types=1);

namespace Arbify\Contracts\Repositories;

use Arbify\Models\Project;
use Arbify\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function byId(int $id): User;

    public function all(): Collection;

    public function allPaginated(): LengthAwarePaginator;

    public function allNotInProject(Project $project): Collection;
}
