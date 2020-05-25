<?php

declare(strict_types=1);

namespace App\Facades;

use App\Contracts\Repositories\SettingsRepository;
use Illuminate\Support\Facades\Facade;

class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SettingsRepository::class;
    }
}
