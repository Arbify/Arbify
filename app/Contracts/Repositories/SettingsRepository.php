<?php

declare(strict_types=1);

namespace Arbify\Contracts\Repositories;

interface SettingsRepository
{
    public function allAsAssociativeArray(): array;

    public function saveAll(array $settings): void;
}
