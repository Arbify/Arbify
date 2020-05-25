<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Setting;
use Arr;

class SettingsRepository implements \App\Contracts\Repositories\SettingsRepository
{
    public function allAsAssociativeArray(): array
    {
        return Arr::collapse(
            Setting::all()
                ->map(fn(Setting $setting) => [$setting->name => $setting->value])
        );
    }

    public function saveAll(array $newSettings): void
    {
        $settingNames = array_keys($newSettings);
        $settings = Setting::whereIn('name', $settingNames)->get();
        foreach ($settings as $setting) {
            if (array_key_exists($setting->name, $newSettings)) {
                $setting->value = $newSettings[$setting->name];
                $setting->update();
            }
        }
    }
}
