<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ProjectRepository as ProjectRepositoryContract;
use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectRepository implements ProjectRepositoryContract
{
    public function byId(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function paginated(): LengthAwarePaginator
    {
        return Project::paginate(30);
    }
}
