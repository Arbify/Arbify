<?php

namespace Tests\Feature;

use App\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testPreferencesShow(): void
    {
        $this->actingAsUser()->get('/account/preferences')
            ->assertOk()
            ->assertSeeText('Preferences')
            ->assertSeeText('Update preferences');
    }

    public function testChangePasswordShows(): void
    {
        $this->actingAsUser()->get('/account/change-password')
            ->assertOk()
            ->assertSeeText('Change password')
            ->assertSeeText('New password')
            ->assertSeeText('Update password');
    }

    public function testUpdatePasswordWithCorrectData(): void
    {
        $user = factory(User::class)->create();
        $newPassword = $this->faker()->password(8);

        $this->actingAs($user)->post('/account/change-password', [
            'old_password' => 'password',
            'new_password' => $newPassword,
            'new_password_confirmation' => $newPassword,
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertTrue(Hash::check($newPassword, $user->password));
    }
}
