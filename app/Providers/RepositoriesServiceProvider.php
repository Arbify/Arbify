<?php

namespace App\Providers;

use App\Contracts\Repositories as RepositoryContracts;
use App\Repositories\LanguageRepository;
use App\Repositories\MessageValueRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    public array $singletons = [
        RepositoryContracts\LanguageRepository::class => LanguageRepository::class,
        RepositoryContracts\MessageValueRepository::class => MessageValueRepository::class,
    ];
}
