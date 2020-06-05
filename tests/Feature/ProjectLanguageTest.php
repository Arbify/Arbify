<?php

declare(strict_types=1);

namespace Tests\Feature;

use Arbify\Models\Language;
use Arbify\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectLanguageTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testCreateLanguageShows(): void
    {
        $project = factory(Project::class)->create();

        $this->actingAsUser()->get("/projects/$project->id/languages/create")
            ->assertOk()
            ->assertSeeText('Language')
            ->assertSeeText('Add language');
    }

    public function testStoreLanguageWithCorrectData(): void
    {
        $project = factory(Project::class)->create();
        $language = factory(Language::class)->create();

        $this->actingAsUser()->post("/projects/$project->id/languages", [
            'languages' => [$language->id],
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas(
            'language_project',
            ['language_id' => $language->id, 'project_id' => $project->id]
        );
    }

    public function testDestroyLanguageWithCorrectData(): void
    {
        $language = factory(Language::class)->create();
        $project = factory(Project::class)->create();
        $project->languages()->attach($language);

        $this->actingAsUser()->delete("/projects/$project->id/languages/$language->code")
            ->assertRedirect();

        $this->assertDatabaseMissing(
            'language_project',
            ['language_id' => $language->id, 'project_id' => $project->id]
        );
    }
}
