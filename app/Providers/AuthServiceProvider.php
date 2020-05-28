<?php

namespace Arbify\Providers;

use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\MessageValue;
use Arbify\Models\Project;
use Arbify\Models\ProjectMember;
use Arbify\Models\User;
use Arbify\Policies\AdministrationPolicy;
use Arbify\Policies\LanguagePolicy;
use Arbify\Policies\MessagePolicy;
use Arbify\Policies\MessageValuePolicy;
use Arbify\Policies\ProjectMemberPolicy;
use Arbify\Policies\ProjectPolicy;
use Arbify\Policies\SecretPolicy;
use Arbify\Policies\UserPolicy;
use Gate;
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
    }
}
