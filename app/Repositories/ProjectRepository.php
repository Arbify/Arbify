<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ProjectRepository as ProjectRepositoryContract;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;

class ProjectRepository implements ProjectRepositoryContract
{
    public function byId(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function visibleToUserPaginated(User $user): LengthAwarePaginator
    {
        return Project::query()
            ->where('visibility', '=', Project::VISIBILITY_PUBLIC)
            ->orWhereExists(function (Builder $builder) use ($user) {
                $builder
                    ->from('projects')
                    ->join('project_roles', 'project_roles.project_id', '=', 'projects.id')
                    ->where('project_roles.user_id', '=', $user->id);
            })
            ->paginate(30);
    }

    public function allPaginated(): LengthAwarePaginator
    {
        return Project::paginate(30);
    }
}
