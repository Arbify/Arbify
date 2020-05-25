<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\SettingsRepository as SettingsRepositoryContract;
use App\Models\Setting;
use Arr;
use Cache;

class SettingsRepository implements SettingsRepositoryContract
{
    public function allAsAssociativeArray(): array
    {
        return Cache::remember('settings', now()->addMinute(), function () {
            return Arr::collapse(
                Setting::all()
                    ->map(fn(Setting $setting) => [$setting->name => $setting->value])
            );
        });
    }

    public function saveAll(array $newSettings): void
    {
        $settingNames = array_keys($newSettings);
        $settings = Setting::whereIn('name', $settingNames)->get();
        foreach ($settings as $setting) {
            if (array_key_exists($setting->name, $newSettings)) {
                $setting->value = $newSettings[$setting->name];
                $setting->update();

                Cache::forget('settings');
            }
        }
    }

    public function defaultLanguage(): int
    {
        return (int) $this->allAsAssociativeArray()['default_language'];
    }
}
