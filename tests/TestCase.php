<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function actingAsUser(bool $verified = true): self
    {
        return $this->actingAs(factory(User::class)->create(
            [
                'email_verified_at' => $verified ? now() : null,
            ]
        ));
    }
}
