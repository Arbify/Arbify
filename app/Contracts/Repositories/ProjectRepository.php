<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectRepository
{
    public function byId(int $id): Project;

    public function paginated(): LengthAwarePaginator;
}
