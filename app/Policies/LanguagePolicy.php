<?php

namespace Arbify\Policies;

use Arbify\Models\Language;
use Arbify\Models\User;

class LanguagePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        // Languages are visible for everyone but guests.
        return !$user->isGuest();
    }

    public function create(User $user): bool
    {
        return $this->hasAdministrativeRights($user);
    }

    public function update(User $user, Language $language): bool
    {
        return $this->hasAdministrativeRights($user);
    }

    public function delete(User $user, Language $language): bool
    {
        return $this->hasAdministrativeRights($user);
    }
}
