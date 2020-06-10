<?php

declare(strict_types=1);

namespace Arbify\Contracts\Repositories;

use Arbify\Models\Project;
use Arbify\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectRepository
{
    public function byId(int $id): Project;

    public function visibleToUserPaginated(User $user): LengthAwarePaginator;

    public function allPaginated(): LengthAwarePaginator;
}
