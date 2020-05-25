<?php

namespace Tests\Unit\Arb;

use App\Arb\ArbFormatter;
use App\Models\Message;
use App\Models\MessageValue;
use Tests\TestCase;

class ArbExporterTest extends TestCase
{
    public function testExportingWithOneMessage(): void
    {
        $message = Message::make([
            'name' => 'test_message',
            'description' => 'This is a message description.',
            'type' => Message::TYPE_MESSAGE,
        ]);
        $value = MessageValue::make([
            'value' => 'Test message value',
            'message_id' => $message->id,
            'updated_at' => now(),
        ]);

        $messages = collect([$message]);
        $values = collect([$value]);

        $arbExporter = new ArbFormatter();
        $result = $arbExporter->format('en', $messages, $values);

        $this->assertJson($result);

        $json = json_decode($result, true);

        $this->assertEquals('en', $json['@@locale']);
        $this->assertArrayHasKey('test_message', $json);
        $this->assertArrayHasKey('@test_message', $json);
    }

    public function testExportingWithPluralMessage(): void
    {
        $message = Message::make([
            'name' => 'apple_number',
            'description' => 'Message with number of apples.',
            'type' => Message::TYPE_PLURAL,
        ]);
        $messages = collect([$message]);

        $values = collect();
        $values->push(MessageValue::make([
            'value' => 'There is one apple.',
            'message_id' => $message->id,
            'form' => 'one',
            'updated_at' => now(),
        ]));
        $values->push(MessageValue::make([
            'value' => 'There is {count} apples.',
            'message_id' => $message->id,
            'form' => 'other',
            'updated_at' => now(),
        ]));

        $arbExporter = new ArbFormatter();
        $result = $arbExporter->format('en', $messages, $values);

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
