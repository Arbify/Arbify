<?php

declare(strict_types=1);

namespace Arbify\Security\Policies;

use Arbify\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class BasePolicy
{
    use HandlesAuthorization;

    protected function hasAdministrativeRights(User $user): bool
    {
        return $user->isSuperAdministrator() || $user->isAdministrator();
    }
}
