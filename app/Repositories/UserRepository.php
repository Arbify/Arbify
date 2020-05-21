<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\UserRepository as UserRepositoryContract;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryContract
{
    public function byId(int $id): User
    {
        return User::findOrFail($id);
    }

    public function paginated(): LengthAwarePaginator
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
}
