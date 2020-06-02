<?php

namespace Arbify\Providers;

use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\MessageValue;
use Arbify\Models\Project;
use Arbify\Models\ProjectMember;
use Arbify\Models\User;
use Arbify\Security\Authentication\UsernameOrEmailUserProvider;
use Arbify\Security\Policies\AdministrationPolicy;
use Arbify\Security\Policies\LanguagePolicy;
use Arbify\Security\Policies\MessagePolicy;
use Arbify\Security\Policies\MessageValuePolicy;
use Arbify\Security\Policies\ProjectMemberPolicy;
use Arbify\Security\Policies\ProjectPolicy;
use Arbify\Security\Policies\SecretPolicy;
use Arbify\Security\Policies\UserPolicy;
use Auth;
use Gate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken as Secret;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Language::class      => LanguagePolicy::class,
        Message::class       => MessagePolicy::class,
        MessageValue::class  => MessageValuePolicy::class,
        Project::class       => ProjectPolicy::class,
        ProjectMember::class => ProjectMemberPolicy::class,
        User::class          => UserPolicy::class,
        Secret::class        => SecretPolicy::class
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('administration', AdministrationPolicy::class);

        Auth::provider('username-or-email', function (Application $app, array $config) {
            return new UsernameOrEmailUserProvider($app->make('hash'), $config['model']);
        });
    }
}
