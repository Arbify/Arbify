<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function actingAsUser(bool $verified = true): self
    {
        return $this->actingAs(factory(User::class)->create(
            [
                'email_verified_at' => $verified ? now() : null,
                'role' => User::ROLE_SUPER_ADMINISTRATOR,
            ]
        ));
    }
}
