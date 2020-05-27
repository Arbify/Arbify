<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Message;
use App\Models\MessageValue;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use App\Policies\AdministrationPolicy;
use App\Policies\LanguagePolicy;
use App\Policies\MessagePolicy;
use App\Policies\MessageValuePolicy;
use App\Policies\ProjectMemberPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\SecretPolicy;
use App\Policies\UserPolicy;
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
