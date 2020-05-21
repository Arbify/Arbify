<?php

use App\Models\Language;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Trail;

Breadcrumbs::for('dashboard', function (Trail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('projects.index', function (Trail $trail) {
    $trail->push('Projects', route('projects.index'));
});

Breadcrumbs::for('projects.create', function (Trail $trail) {
    $trail->parent('projects.index');
    $trail->push('New project', route('projects.create'));
});

Breadcrumbs::for('projects.show', function (Trail $trail, Project $project) {
    $trail->parent('projects.index');
    $trail->push($project->name, route('projects.show', $project));
});

Breadcrumbs::for('projects.edit', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Edit', route('projects.edit', $project));
});

Breadcrumbs::for('projects.create-language', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Add language', route('projects.create-language', $project));
});

Breadcrumbs::for('projects.export', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Export', route('projects.export', $project));
});

Breadcrumbs::for('messages.index', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Messages', route('messages.index', $project));
});

Breadcrumbs::for('messages.create', function (Trail $trail, Project $project) {
    $trail->parent('messages.index', $project);
    $trail->push('New message', route('messages.create', $project));
});

Breadcrumbs::for('messages.edit', function (Trail $trail, Project $project, Message $message) {
    $trail->parent('messages.index', $project);
    $trail->push($message->name);
    $trail->push('Edit', route('messages.edit', [$project, $message]));
});

Breadcrumbs::for('project-members.index', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Project roles', route('project-members.index', $project));
});

Breadcrumbs::for('languages.index', function (Trail $trail) {
    $trail->push('Languages', route('languages.index'));
});

Breadcrumbs::for('languages.create', function (Trail $trail) {
    $trail->parent('languages.index');
    $trail->push('New language', route('languages.create'));
});

Breadcrumbs::for('languages.edit', function (Trail $trail, Language $language) {
    $trail->parent('languages.index');
    $trail->push($language->code);
    $trail->push('Edit', route('languages.edit', $language));
});

Breadcrumbs::for('users.index', function (Trail $trail) {
    $trail->push('Users', route('users.index'));
});

Breadcrumbs::for('users.create', function (Trail $trail) {
    $trail->parent('users.index');
    $trail->push('New user', route('users.create'));
});

Breadcrumbs::for('users.edit', function (Trail $trail, User $user) {
    $trail->parent('users.index');
    $trail->push($user->name);
    $trail->push('Edit', route('users.edit', $user));
});

Breadcrumbs::for('account.index', function (Trail $trail) {
    $trail->push('Account');
});

Breadcrumbs::for('account.preferences', function (Trail $trail) {
    $trail->parent('account.index');
    $trail->push('Preferences', route('account.preferences'));
});

Breadcrumbs::for('account.change-password', function (Trail $trail) {
    $trail->parent('account.index');
    $trail->push('Change password', route('account.change-password'));
});
