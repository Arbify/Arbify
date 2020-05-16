<?php

namespace Tests\Unit\Arb;

use App\Arb\ArbExporter;
use App\Models\Language;
use App\Models\Message;
use App\Models\MessageValue;
use App\Models\Project;
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

    public function testExportingWithPluralMessage(): void
    {
        $message = Message::create([
            'name' => 'apple_number',
            'description' => 'Message with number of apples.',
            'type' => Message::TYPE_PLURAL,
            'project_id' => factory(Project::class)->create()->id,
        ]);
        $language = factory(Language::class)->create(['code' => 'en']);

        $values = collect();
        $values->push(MessageValue::create([
            'value' => 'There is one apple.',
            'message_id' => $message->id,
            'language_id' => $language->id,
            'form' => 'one'
        ]));
        $values->push(MessageValue::create([
            'value' => 'There is {count} apples.',
            'message_id' => $message->id,
            'language_id' => $language->id,
            'form' => 'other'
        ]));

        $arbExporter = new ArbExporter();
        $result = $arbExporter->exportToArb('en', $values);

        $this->assertJson($result);

        $json = json_decode($result, true);

        $this->assertEquals('en', $json['@@locale']);
        $this->assertArrayHasKey('apple_number', $json);
        $this->assertEquals(
            '{count, plural, one {There is one apple.} other {There is {count} apples.}}',
            $json['apple_number']
        );
        $this->assertArrayHasKey('@apple_number', $json);
        $this->assertEquals(
            'Message with number of apples.',
            $json['@apple_number']['description']
        );
    }
}
