<?php

namespace App\Providers;

use App\Contracts\Repositories as Contracts;
use App\Repositories as Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    public array $singletons = [
        Contracts\LanguageRepository::class      => Repositories\LanguageRepository::class,
        Contracts\MessageRepository::class       => Repositories\MessageRepository::class,
        Contracts\MessageValueRepository::class  => Repositories\MessageValueRepository::class,
        Contracts\ProjectRepository::class       => Repositories\ProjectRepository::class,
        Contracts\ProjectMemberRepository::class => Repositories\ProjectMemberRepository::class,
        Contracts\UserRepository::class          => Repositories\UserRepository::class,
    ];
}
