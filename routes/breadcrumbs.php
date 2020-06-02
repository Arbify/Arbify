<?php

use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\Project;
use Arbify\Models\ProjectMember;
use Arbify\Models\User;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Trail;

Breadcrumbs::for('dashboard', function (Trail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('projects.index', function (Trail $trail) {
    $trail->push('Projects', route('projects.index'));
});

Breadcrumbs::for('projects.create', function (Trail $trail) {
    $trail->parent('projects.index');
    $trail->push('New', route('projects.create'));
});

Breadcrumbs::for('projects.show', function (Trail $trail, Project $project) {
    $trail->parent('projects.index');
    $trail->push($project->name, route('projects.show', $project));
});

Breadcrumbs::for('projects.edit', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Edit', route('projects.edit', $project));
});

Breadcrumbs::for('projects.import', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Import', route('projects.import', $project));
});
Breadcrumbs::for('projects.export', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Export', route('projects.export', $project));
});

Breadcrumbs::for('project-languages.index', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Languages', route('project-languages.index', $project));
});

Breadcrumbs::for('project-languages.create', function (Trail $trail, Project $project) {
    $trail->parent('project-languages.index', $project);
    $trail->push('Add', route('project-languages.create', $project));
});

Breadcrumbs::for('messages.index', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Messages', route('messages.index', $project));
});

Breadcrumbs::for('messages.create', function (Trail $trail, Project $project) {
    $trail->parent('messages.index', $project);
    $trail->push('New', route('messages.create', $project));
});

Breadcrumbs::for('messages.edit', function (Trail $trail, Project $project, Message $message) {
    $trail->parent('messages.index', $project);
    $trail->push($message->name);
    $trail->push('Edit', route('messages.edit', [$project, $message]));
});

Breadcrumbs::for('project-members.index', function (Trail $trail, Project $project) {
    $trail->parent('projects.show', $project);
    $trail->push('Members', route('project-members.index', $project));
});

Breadcrumbs::for('project-members.create', function (Trail $trail, Project $project) {
    $trail->parent('project-members.index', $project);
    $trail->push('Add', route('project-members.create', $project));
});

Breadcrumbs::for('project-members.edit', function (Trail $trail, Project $project, ProjectMember $projectMember) {
    $trail->parent('project-members.index', $project);
    $trail->push($projectMember->user->name);
    $trail->push('Edit', route('project-members.edit', [$project, $projectMember]));
});

Breadcrumbs::for('languages.index', function (Trail $trail) {
    $trail->push('Languages', route('languages.index'));
});

Breadcrumbs::for('languages.create', function (Trail $trail) {
    $trail->parent('languages.index');
    $trail->push('New', route('languages.create'));
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
    $trail->push('New', route('users.create'));
});

Breadcrumbs::for('users.edit', function (Trail $trail, User $user) {
    $trail->parent('users.index');
    $trail->push($user->username);
    $trail->push('Edit', route('users.edit', $user));
});

Breadcrumbs::for('administration', function (Trail $trail) {
    $trail->push('Administration');
});

Breadcrumbs::for('administration.statistics', function (Trail $trail) {
    $trail->parent('administration');
    $trail->push('Statistics', route('administration.statistics'));
});

Breadcrumbs::for('administration.settings', function (Trail $trail) {
    $trail->parent('administration');
    $trail->push('Settings', route('administration.settings'));
});

Breadcrumbs::for('administration.logs', function (Trail $trail) {
    $trail->parent('administration');
    $trail->push('Logs', route('administration.logs'));
});

Breadcrumbs::for('account.index', function (Trail $trail) {
    $trail->push('Account');
});

Breadcrumbs::for('account-secrets.index', function (Trail $trail) {
    $trail->parent('account.index');
    $trail->push('Secrets', route('account-secrets.index'));
});

Breadcrumbs::for('account-secrets.create', function (Trail $trail) {
    $trail->parent('account-secrets.index');
    $trail->push('New', route('account-secrets.create'));
});

Breadcrumbs::for('account.preferences', function (Trail $trail) {
    $trail->parent('account.index');
    $trail->push('Preferences', route('account.preferences'));
});

Breadcrumbs::for('account.change-password', function (Trail $trail) {
    $trail->parent('account.index');
    $trail->push('Change password', route('account.change-password'));
});
