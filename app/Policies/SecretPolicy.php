<?php

namespace Arbify\Policies;

use Arbify\Models\User;
use Laravel\Sanctum\PersonalAccessToken as Secret;

class SecretPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function revoke(User $user, Secret $secret): bool
    {
        return $user->id === $secret->tokenable->id;
    }
}
