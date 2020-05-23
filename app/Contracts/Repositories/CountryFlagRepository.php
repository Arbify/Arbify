<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

interface CountryFlagRepository
{
    public function getAllFlags(): array;
}
