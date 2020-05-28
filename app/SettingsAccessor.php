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
        return (int) $this->getSetting('default_language');
    }

    public function registrationEnabled(): bool
    {
        return (bool) $this->getSetting('registration_enabled');
    }

    private function getSetting(string $name): ?string
    {
        return $this->settingsRepository->allAsAssociativeArray()[$name];
    }
}
