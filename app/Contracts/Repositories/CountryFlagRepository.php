<?php

declare(strict_types=1);

namespace Arbify\Contracts\Repositories;

interface CountryFlagRepository
{
    public function getAllFlags(): array;
}
