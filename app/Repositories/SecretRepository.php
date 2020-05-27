<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\SecretRepository as SecretRepositoryContract;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Laravel\Sanctum\PersonalAccessToken;

class SecretRepository implements SecretRepositoryContract
{
    public function byId(int $id): PersonalAccessToken
    {
        return PersonalAccessToken::findOrFail($id);
    }

    public function allByUser(User $user): LengthAwarePaginator
    {
        return $user->tokens()
            ->orderBy('last_used_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(30);
    }
}
