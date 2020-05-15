<?php

use App\Language;
use App\Message;
use App\Project;
use App\User;
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
    $trail->push($project->name, route('projects.edit', $project));
});

Breadcrumbs::for('projects.languages.create', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Add language', route('projects.languages.create', $project));
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
    $trail->push('New user', route('users.edit', $user));
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
