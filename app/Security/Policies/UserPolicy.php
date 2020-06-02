<?php

namespace Arbify\Security\Policies;

use Arbify\Models\User;

class UserPolicy extends BasePolicy
{
    public function before(User $user, $ability): ?bool
    {
        // User has to be an administrator or a super administrator to access users.
        if (!$this->hasAdministrativeRights($user)) {
            return false;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, User $model): bool
    {
        return $this->modifyUser($user, $model);
    }

    public function delete(User $user, User $model): bool
    {
        // User can't delete himself.
        if ($user->id === $model->id) {
            return false;
        }

        return $this->modifyUser($user, $model);
    }

    public function createRole(User $user, int $role): bool
    {
        return $this->giveRole($user, $role);
    }

    public function updateRole(User $user, User $model, int $role): bool
    {
        // User can't change his own role.
        if ($user->id === $model->id) {
            return false;
        }

        return $this->giveRole($user, $role);
    }

    private function modifyUser(User $user, User $model): bool
    {
        // Super administrator can be modified only by other super administrators.
        if ($model->isSuperAdministrator() && $user->isAdministrator()) {
            return false;
        }

        return true;
    }

    private function giveRole(User $user, int $role): bool
    {
        // Only super administrators can make other users (super) administrators.
        if (in_array($role, [User::ROLE_SUPER_ADMINISTRATOR, User::ROLE_ADMINISTRATOR])) {
            return $user->isSuperAdministrator();
        }

        return true;
    }
}
