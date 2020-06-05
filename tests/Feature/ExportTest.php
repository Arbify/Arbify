<?php

declare(strict_types=1);

namespace Tests\Feature;

use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\MessageValue;
use Arbify\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

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

        $json = json_decode($response->streamedContent(), true);

        $this->assertEquals($language->code, $json['@@locale']);
        $this->assertEquals($messageValue->value, $json[$message->name]);
    }
}
