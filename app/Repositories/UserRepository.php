<?php

declare(strict_types=1);

namespace Arbify\Repositories;

use Arbify\Contracts\Repositories\UserRepository as UserRepositoryContract;
use Arbify\Models\Project;
use Arbify\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryContract
{
    public function byId(int $id): User
    {
        return User::findOrFail($id);
    }

    public function all(): Collection
    {
        return User::all();
    }

    public function allPaginated(): LengthAwarePaginator
    {
        // So that we firstly order users by role significance, descending.
        $userRolesWhens = collect(User::ROLES)
            ->map(fn($role, $index) => "WHEN $role THEN $index")
            ->implode(' ');
        $userRoleOrdering = "CASE `role` $userRolesWhens END";

        return User::orderByRaw($userRoleOrdering)
            ->orderBy('name')
            ->paginate(30);
    }

    public function allNotInProject(Project $project): Collection
    {
        $usersInProjectIds = $project->projectMembers->map(fn($member) => $member->user->id);

        return User::whereNotIn('id', $usersInProjectIds)->get();
    }
}
