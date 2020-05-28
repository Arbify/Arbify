<?php

namespace Tests\Feature;

use Arbify\Models\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndexShows(): void
    {
        $language = factory(Language::class)->create();

        $this->actingAsUser()->get('/languages')
            ->assertOk()
            ->assertSeeText('Languages')
            ->assertSeeText($language->code);
    }

    public function testCreateShows(): void
    {
        $this->actingAsUser()->get('/languages/create')
            ->assertOk()
            ->assertSeeText('Language code')
            ->assertSeeText('Create language');
    }

    public function testStoreWithCorrectData(): void
    {
        $code = $this->faker()->locale;

        $this->actingAsUser()->post('/languages', [
            'code' => $code,
            'name' => $this->faker()->country,
            'flag' => $this->faker()->countryCode,
            'plural_forms' => factory(Language::class)->make()->plural_forms,
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('languages', ['code' => $code]);
    }

    public function testEditShows(): void
    {
        $language = factory(Language::class)->create();

        $this->actingAsUser()->get("/languages/$language->id/edit")
            ->assertOk()
            ->assertSee($language->code)
            ->assertSeeText('Update language');
    }

    public function testUpdateWithCorrectData(): void
    {
        $language = factory(Language::class)->create();
        $newName = $this->faker()->country;

        $this->actingAsUser()->patch("/languages/$language->id", [
            'code' => $language->code,
            'name' => $newName,
            'flag' => $language->flag,
            'plural_forms' => $language->plural_forms,
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('languages', ['code' => $language->code, 'name' => $newName]);
    }

    public function testDestroyWithCorrectData(): void
    {
        $language = factory(Language::class)->create();

        $this->actingAsUser()->delete("/languages/$language->id")
            ->assertRedirect();

        $this->assertDatabaseMissing('languages', ['id' => $language->id]);
    }
}
