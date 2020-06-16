<?php

declare(strict_types=1);

namespace Arbify\Repositories;

use Arbify\Contracts\Repositories\ProjectRepository as ProjectRepositoryContract;
use Arbify\Models\Project;
use Arbify\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\JoinClause;

class ProjectRepository implements ProjectRepositoryContract
{
    public function byId(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function visibleToUserPaginated(User $user): LengthAwarePaginator
    {
        return Project::select('projects.*')
            ->leftJoin('project_members', function (JoinClause $builder) use ($user) {
                $builder
                    ->on('project_members.project_id', '=', 'projects.id')
                    ->where('project_members.user_id', '=', $user->id);
            })
            ->where('visibility', '=', Project::VISIBILITY_PUBLIC)
            ->orWhereNotNull('project_members.id')
            ->orderByRaw('CASE WHEN `project_members`.`id` IS NOT NULL THEN 0 ELSE 1 END')
            ->orderBy('name')
            ->paginate(30);
    }

    public function allPaginated(User $user): LengthAwarePaginator
    {
        return Project::select('projects.*')
            ->leftJoin('project_members', function (JoinClause $builder) use ($user) {
                $builder
                    ->on('project_members.project_id', '=', 'projects.id')
                    ->where('project_members.user_id', '=', $user->id);
            })
            ->orderByRaw('CASE WHEN `project_members`.`id` IS NOT NULL THEN 0 ELSE 1 END')
            ->orderBy('name')->paginate(30);
    }
}
