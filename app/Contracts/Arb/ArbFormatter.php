<?php

declare(strict_types=1);

namespace App\Contracts\Arb;

use App\Models\Message;
use Illuminate\Support\Collection;

interface ArbFormatter
{
    /**
     * Returns ARB string with messages localized in a given locale.
     *
     * @param string $locale
     * @param Collection $messages
     * @param Collection $values
     *
     * @return string
     */
    public function format(string $locale, Collection $messages, Collection $values): string;

    public function formatLocale(string $locale): array;

    public function formatLastModified(Collection $values): array;

    public function formatValue(Message $message, Collection $values): array;
}
