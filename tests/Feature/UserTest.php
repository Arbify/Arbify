<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndexShows(): void
    {
        $user = factory(User::class)->create();

        $this->actingAsUser()->get('/users')
            ->assertOk()
            ->assertSeeText($user->email);
    }

    public function testCreateShows(): void
    {
        $this->actingAsUser()->get('/users/create')
            ->assertOk()
            ->assertSeeText('Email')
            ->assertSeeText('Create user');
    }

    public function testStoreWithCorrectData(): void
    {
        $data = factory(User::class)->make();
        $email = $data->email;

        $this->actingAsUser()->post('/users', [
            'name' => $data->name,
            'email' => $email,
            'password' => $data->password,
            'role' => $data->role,
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['email' => $email]);
    }

    public function testEditShows(): void
    {
        $user = factory(User::class)->create();

        $this->actingAsUser()->get("/users/$user->id/edit")
            ->assertOk()
            ->assertSee($user->email)
            ->assertSeeText('Update user');
    }

    public function testUpdateWithCorrectData(): void
    {
        $user = factory(User::class)->create();
        $name = $this->faker()->name;

        $this->actingAsUser()->patch("/users/$user->id", [
            'name' => $name,
            'email' => $user->email,
            'role' => $user->role,
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['name' => $name, 'email' => $user->email]);
    }

    public function testDestroyWithCorrectData(): void
    {
        $user = factory(User::class)->create();

        $this->actingAsUser()->delete("/users/$user->id")
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
