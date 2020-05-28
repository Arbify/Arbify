<?php

namespace Arbify\Providers;

use Arbify\Contracts\Repositories\LanguageRepository;
use Arbify\Contracts\Repositories\MessageRepository;
use Arbify\Contracts\Repositories\ProjectMemberRepository;
use Arbify\Contracts\Repositories\ProjectRepository;
use Arbify\Contracts\Repositories\SecretRepository;
use Arbify\Contracts\Repositories\UserRepository;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Arbify\Http\Controllers';

    public const HOME = '/';

    public function boot(): void
    {
        $this->bindModels();

        parent::boot();
    }

    private function bindModels(): void
    {
        Route::bind('language', fn($value) => app(LanguageRepository::class)->byId((int) $value));
        Route::bind('language_code', fn($value) => app(LanguageRepository::class)->byCode($value));
        Route::bind('message', fn($value) => app(MessageRepository::class)->byId((int) $value));
        Route::bind('project', fn($value) => app(ProjectRepository::class)->byId((int) $value));
        Route::bind('member', fn($value) => app(ProjectMemberRepository::class)->byId((int) $value));
        Route::bind('secret', fn($value) => app(SecretRepository::class)->byId((int) $value));
        Route::bind('user', fn($value) => app(UserRepository::class)->byId((int) $value));
    }

    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    private function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\Web')
            ->group(base_path('routes/web.php'));
    }

    private function mapApiRoutes(): void
    {
        Route::prefix('/api/v1')
            ->middleware(['api', 'auth:sanctum'])
            ->namespace($this->namespace . '\Api')
            ->name('api-v1')
            ->group(base_path('routes/api-v1.php'));
    }
}
