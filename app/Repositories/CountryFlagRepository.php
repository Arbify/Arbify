<?php

declare(strict_types=1);

namespace App\Repositories;

use Storage;

class CountryFlagRepository implements \App\Contracts\Repositories\CountryFlagRepository
{
    public function getAllFlags(): array
    {
        return collect(Storage::disk('public')->allFiles('flags'))
            ->map(fn($flagPath) => basename($flagPath, '.svg'))
            ->toArray();
    }
}
