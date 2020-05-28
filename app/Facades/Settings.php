<?php

declare(strict_types=1);

namespace Arbify\Facades;

use Arbify\SettingsAccessor;
use Illuminate\Support\Facades\Facade;

class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SettingsAccessor::class;
    }
}
