<?php

namespace Tests\Unit\Arb;

use App\Arb\ArbExporter;
use App\Language;
use App\Message;
use App\MessageValue;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ArbExporterTest extends TestCase
{
    use RefreshDatabase;

    public function testExportingWithOneMessage(): void
    {
        // TODO: When we implement repositories, mock one instead of using DB here :(

        $message = Message::create([
            'name' => 'test_message',
            'description' => 'This is a message description.',
            'type' => Message::TYPE_MESSAGE,
            'project_id' => factory(Project::class)->create()->id,
        ]);
        $language = factory(Language::class)->create(['code' => 'en']);
        $value = MessageValue::create([
            'value' => 'Test message value',
            'message_id' => $message->id,
            'language_id' => $language->id,
        ]);

        $values = new Collection([$value]);

        $arbExporter = new ArbExporter();
        $result = $arbExporter->exportToArb('en', $values);

        $this->assertJson($result);

        $json = json_decode($result, true);

        $this->assertEquals('en', $json['@@locale']);
        $this->assertArrayHasKey('test_message', $json);
        $this->assertArrayHasKey('@test_message', $json);
    }
}
