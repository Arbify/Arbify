<?php

declare(strict_types=1);

namespace Arbify\Arb;

use Arbify\Contracts\Arb\ArbFormatter as ArbFormatterContract;
use Arbify\Models\Message;
use Arbify\Models\MessageValue;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;

/**
 * @see https://github.com/google/app-resource-bundle/wiki/ApplicationResourceBundleSpecification
 */
class ArbFormatter implements ArbFormatterContract
{
    public function format(string $locale, Collection $messages, Collection $values): string
    {
        $result = [];

        $result = array_merge($result, $this->formatLocale($locale));
        $result = array_merge($result, $this->formatLastModified($values));

        // We group all values by message id, so that all forms of the same message stay together.
        $valuesGrouped = $values->groupBy(function (MessageValue $item, $key) {
            return $item->message_id;
        });

        foreach ($valuesGrouped as $messageId => $valuesGroup) {
            /** @var Message $message */
            $message = $messages->firstWhere('id', $messageId);
            if ($message === null) {
                continue;
            }

            $formattedValue = $this->formatValue($message, $valuesGroup);
            $result = array_merge($result, $formattedValue);
        }

        return json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function formatLocale(string $locale): array
    {
        return ['@@locale' => $locale];
    }

    public function formatLastModified(Collection $values): array
    {
        /** @var Carbon $lastModified */
        $lastModified = $values->max(function (MessageValue $value) {
            return $value->updated_at;
        });

        if ($lastModified == null) {
            return [];
        }

        return ['@@last_modified' => $lastModified->toIso8601String()];
    }

    public function formatValue(Message $message, Collection $values): array
    {
        switch ($message->type) {
            case Message::TYPE_MESSAGE:
                $value = is_null($values->first()->value) ? null : $this->escapeValue($values->first()->value);
                break;
            case Message::TYPE_PLURAL:
                $value = $this->formatPluralValue($values);
                break;
            case Message::TYPE_GENDER:
                $value = $this->formatGenderValue($values);
                break;
            default:
                throw new Exception("Message type \"$message->type\" is not a type supported by exporter.");
        }

        if (is_null($value)) {
            return [];
        }

        $attributes = [];
        if (!is_null($message->description)) {
            $attributes['description'] = $message->description;
        }

        $return = [$message->name => $value];
        if (!empty($attributes)) {
            $return["@$message->name"] = $attributes;
        }

        return $return;
    }

    private function formatPluralValue(Collection $values): string
    {
        $forms = [];
        foreach ($values as $value) {
            if (is_null($value->value)) {
                continue;
            }

            $forms[] = sprintf('%s {%s}', $value->form, $this->escapeValue($value->value));
        }

        return sprintf('{count, plural, %s}', implode(' ', $forms));
    }

    private function formatGenderValue(Collection $values): string
    {
        $forms = [];
        foreach ($values as $value) {
            if (is_null($value->value)) {
                continue;
            }

            $forms[] = sprintf('%s {%s}', $value->form, $this->escapeValue($value->value));
        }

        return sprintf('{gender, gender, %s}', implode(' ', $forms));
    }

    private function escapeValue(?string $value): string
    {
        return $value ?? '';
    }
}
