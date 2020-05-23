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
        // So that we firstly order members by role significance, descending.
        $memberRolesWhens = collect(ProjectMember::ROLES)
            ->map(fn($role, $index) => "WHEN $role THEN $index")
            ->implode(' ');
        $memberRoleOrdering = "CASE project_members.role $memberRolesWhens END";

        return $project->projectMembers()
            ->select('project_members.*')
            ->join('users', 'project_members.user_id', '=', 'users.id')
            ->orderByRaw($memberRoleOrdering)
            ->orderBy('users.email')
            ->get();
    }

    public function byProjectAndUserOrNull(Project $project, User $user): ?ProjectMember
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $project->projectMembers()->firstWhere('user_id', $user->id);
    }
}
