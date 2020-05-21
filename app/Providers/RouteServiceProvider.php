<?php

namespace App\Providers;

use App\Contracts\Repositories\LanguageRepository;
use App\Contracts\Repositories\MessageRepository;
use App\Contracts\Repositories\ProjectMemberRepository;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\UserRepository;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     */
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
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    private function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
