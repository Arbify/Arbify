<?php

declare(strict_types=1);

namespace Arbify\Security\Authentication;

use Illuminate\Auth\EloquentUserProvider;

class UsernameOrEmailUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        if (!isset($credentials['username_or_email'])) {
            return null;
        }

        $login = $credentials['username_or_email'];

        return $this->newModelQuery()
            ->where('email', $login)
            ->orWhere('username', $login)
            ->first();
    }
}
