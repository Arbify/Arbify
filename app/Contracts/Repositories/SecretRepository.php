<?php

declare(strict_types=1);

namespace Arbify\Contracts\Repositories;

use Arbify\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Laravel\Sanctum\PersonalAccessToken as Secret;

interface SecretRepository
{
    public function byId(int $id): Secret;

    public function allByUser(User $user): LengthAwarePaginator;
}
