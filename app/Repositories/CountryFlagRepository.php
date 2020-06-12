<?php

declare(strict_types=1);

namespace Arbify\Repositories;

class CountryFlagRepository implements \Arbify\Contracts\Repositories\CountryFlagRepository
{
    public function getAllFlags(): array
    {
        $flags = glob(resource_path('images/flags') . '/*.svg');

        return collect($flags)
            ->map(fn($flagPath) => basename($flagPath, '.svg'))
            ->toArray();
    }
}
