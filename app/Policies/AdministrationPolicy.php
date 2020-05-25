<?php

namespace App\Policies;

use App\Models\User;

class AdministrationPolicy extends BasePolicy
{
    public function __invoke(User $user): bool
    {
        return $user->isSuperAdministrator();
    }
}
