<?php

namespace App\Providers;

use App\Contracts\Repositories\LanguageRepository;
use App\Contracts\Repositories\MessageRepository;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\UserRepository;
use App\Models\Language;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        Route::bind('project', function ($value) {
            return app(ProjectRepository::class)->byId((int) $value);
        });

        Route::bind('message', function ($value) {
            return app(MessageRepository::class)->byId((int) $value);
        });

        Route::bind('language_code', function ($value) {
            return app(LanguageRepository::class)->byCode($value);
        });

        Route::bind('language', function ($value) {
            return app(LanguageRepository::class)->byId((int) $value);
        });

        Route::bind('user', function ($value) {
            return app(UserRepository::class)->byId((int) $value);
        });

        parent::boot();
    }

    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
