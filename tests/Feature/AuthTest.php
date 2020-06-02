<?php

namespace Tests\Feature;

use Arbify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testLoginFormShows(): void
    {
        $this->get('/login')
            ->assertSeeText('Username or email')
            ->assertSeeText('Password')
            ->assertOk();
    }

    public function testLoginWithCorrectCredentials(): void
    {
        $user = factory(User::class)->create();

        $this->post('/login', [
            'username_or_email' => $user->email,
            'password' => 'password',
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();
    }

    public function testLoginWithBadEmail(): void
    {
        $this->post('/login', [
            'username_or_email' => 'not-existing-email',
            'password' => 'password',
        ])
            ->assertSessionHasErrors()
            ->assertRedirect();
    }

    public function testRegisterShows(): void
    {
        $this->get('/register')
            ->assertSeeText('Register')
            ->assertSeeText('Username')
            ->assertSeeText('Email')
            ->assertSeeText('Password')
            ->assertOk();
    }

    public function testRegister(): void
    {
        $email = $this->faker()->safeEmail();
        $password = $this->faker()->password(8);

        $this->post('/register', [
            'username' => $this->faker()->name(),
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['email' => $email]);
    }
}
