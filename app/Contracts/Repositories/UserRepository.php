<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function byId(int $id): User;

    public function all(): Collection;

    public function allPaginated(): LengthAwarePaginator;
}
