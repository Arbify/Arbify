<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ProjectMemberRepository as ProjectMemberRepositoryContract;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Support\Collection;

class ProjectMemberRepository implements ProjectMemberRepositoryContract
{
    public function byId(int $id): ProjectMember
    {
        return ProjectMember::findOrFail($id);
    }

    public function allInProject(Project $project): Collection
    {
        return $project->projectMembers()->get();
    }

    public function byProjectAndUserOrNull(Project $project, User $user): ?ProjectMember
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $project->projectMembers()->firstWhere('user_id', $user->id);
    }
}
