<?php

declare(strict_types=1);

namespace App;

use App\Contracts\Repositories\SettingsRepository;

class SettingsAccessor
{
    private SettingsRepository $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function defaultLanguage(): int
    {
        return (int) $this->settingsRepository->allAsAssociativeArray()['default_language'];
    }
}
