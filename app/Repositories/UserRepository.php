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
        return User::paginate(30);
    }
}
