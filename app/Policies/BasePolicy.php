<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class BasePolicy
{
    use HandlesAuthorization;

    protected function hasAdministrativeRights(User $user): bool
    {
        return $user->isSuperAdministrator() || $user->isAdministrator();
    }
}
