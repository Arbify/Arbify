<?php

declare(strict_types=1);

namespace App\Arb;

use App\MessageValue;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * @see https://github.com/google/app-resource-bundle/wiki/ApplicationResourceBundleSpecification
 */
class ArbExporter
{
    public function exportToArb(string $locale, Collection $messages): string
    {
        $result = [];

        $result = array_merge($result, $this->formatLocale($locale));
        $result = array_merge($result, $this->formatLastModified($messages));

        foreach ($messages as $value) {
            $formattedValue = $this->formatValue($value);
            $result = array_merge($result, $formattedValue);
        }

        return json_encode($result, JSON_PRETTY_PRINT);
    }

    private function formatLocale(string $locale): array
    {
        return ['@@locale' => $locale];
    }

    private function formatLastModified(Collection $values): array
    {
        /** @var Carbon $lastModified */
        $lastModified = $values->max(function (MessageValue $value) {
            return $value->updated_at;
        });

        return ['@@last_modified' => $lastModified->toIso8601String()];
    }

    private function formatValue(MessageValue $value): array
    {
        $message = $value->message()->getResults();

        // TODO: Format correctly according to the type

        return [
            $message->name => $value->value,
            "@$message->name" => [
                'type' => 'text',
                'description' => $message->description ?? '',
            ],
        ];
    }
}
