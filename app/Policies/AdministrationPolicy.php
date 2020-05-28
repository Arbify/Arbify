<?php

namespace Arbify\Policies;

use Arbify\Models\User;

class AdministrationPolicy extends BasePolicy
{
    public function __invoke(User $user): bool
    {
        return $user->isSuperAdministrator();
    }
}
