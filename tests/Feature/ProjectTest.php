<?php

namespace Tests\Feature;

use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\MessageValue;
use Arbify\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndexShows(): void
    {
        $project = factory(Project::class)->create();

        $this->actingAsUser()->get('/projects')
            ->assertOk()
            ->assertSeeText('Projects')
            ->assertSeeText($project->name);
    }

    public function testCreateShows(): void
    {
        $this->actingAsUser()->get('/projects/create')
            ->assertOk()
            ->assertSeeText('Project name')
            ->assertSeeText('Create project');
    }

    public function testStoreWithCorrectData(): void
    {
        // Create default language (with id 1)
        factory(Language::class)->create();

        $name = $this->faker()->name;

        $this->actingAsUser()->post('/projects', [
            'name' => $name,
            'visibility' => factory(Project::class)->make()->visibility,
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('projects', ['name' => $name]);
    }

    public function testShowShows(): void
    {
        $project = factory(Project::class)->create();

        $this->actingAsUser()->get("/projects/$project->id")
            ->assertOk()
            ->assertSeeText($project->name);
    }

    public function testEditShows(): void
    {
        $project = factory(Project::class)->create();

        $this->actingAsUser()->get("/projects/$project->id/edit")
            ->assertOk()
            ->assertSee($project->name)
            ->assertSeeText('Update project');
    }

    public function testUpdateWithCorrectData(): void
    {
        $project = factory(Project::class)->create();
        $newName = $this->faker()->name;

        $this->actingAsUser()->patch("/projects/$project->id", [
            'name' => $newName,
            'visibility' => $project->visibility,
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => $newName]);
    }

    public function testDestroyWithCorrectData(): void
    {
        $project = factory(Project::class)->create();

        $this->actingAsUser()->delete("/projects/$project->id")
            ->assertRedirect();

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
