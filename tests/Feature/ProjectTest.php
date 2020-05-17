<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Models\Message;
use App\Models\MessageValue;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndexShows(): void
    {
        $project = factory(Project::class)->create();

        $this->actingAsUser()->get('/projects')
            ->assertOk()
            ->assertSeeText('Project name')
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
        $name = $this->faker()->name;

        $this->actingAsUser()->post('/projects', [
            'name' => $name,
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
            'language' => $language->id,
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

    public function testExportShows(): void
    {
        $project = factory(Project::class)->create();

        $this->actingAsUser()->get("/projects/$project->id/export")
            ->assertOk()
            ->assertSeeText('Export');
    }

    public function testExportLanguage(): void
    {
        $language = factory(Language::class)->create();
        $project = factory(Project::class)->create();
        $project->languages()->attach($language);

        $message = factory(Message::class)->create([
            'type' => Message::TYPE_MESSAGE,
        ]);
        $project->messages()->save($message);

        $messageValue = factory(MessageValue::class)->create([
            'message_id' => $message->id,
            'language_id' => $language->id,
        ]);

        $response = $this->actingAsUser()->post("/projects/$project->id/export", [
            'language' => $language->id,
        ])
            ->assertOk();

        $json = $response->json();

        $this->assertEquals($language->code, $json['@@locale']);
        $this->assertEquals($messageValue->value, $json[$message->name]);
    }
}
