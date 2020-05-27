<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Laravel\Sanctum\PersonalAccessToken as Secret;

interface SecretRepository
{
    public function byId(int $id): Secret;

    public function allByUser(User $user): LengthAwarePaginator;
}
