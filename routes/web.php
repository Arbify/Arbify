<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'verify' => true,
]);

// Dashboard
Route::get('/', 'DashboardController')->name('dashboard');

// Project
Route::resource('/projects', 'Project\ProjectController');

// Project import
Route::get('/projects/{project}/import', 'Project\ImportController@show')->name('projects.import');
Route::post('/projects/{project}/import', 'Project\ImportController@upload')->name('projects.import-upload');

// Project export
Route::get('/projects/{project}/export', 'Project\ExportController@show')->name('projects.export');
Route::post('/projects/{project}/export/all', 'Project\ExportController@all')->name('projects.export-all');
Route::post('/projects/{project}/export', 'Project\ExportController@language')->name('projects.export-language');

// Project language
Route::get('/projects/{project}/languages', 'Project\ProjectLanguageController@index')
    ->name('project-languages.index');
Route::get('/projects/{project}/languages/create', 'Project\ProjectLanguageController@create')
    ->name('project-languages.create');
Route::post('/projects/{project}/languages', 'Project\ProjectLanguageController@store')
    ->name('project-languages.store');
Route::delete('/projects/{project}/languages/{language_code}', 'Project\ProjectLanguageController@destroy')
    ->name('project-languages.destroy');

// Project message
Route::resource('/projects/{project}/messages', 'Project\MessageController')
    ->except(['show']);

// Project message value
Route::put('/projects/{project}/messages/{message}/{language_code}/{form?}', 'Project\MessageValueController@put')
    ->name('message-values.put');
Route::get(
    '/projects/{project}/messages/{message}/{language_code}/history',
    'Project\MessageValueController@history'
)->name('message-values.history');

// Project member
Route::resource('/projects/{project}/members', 'Project\ProjectMemberController', ['names' => 'project-members'])
    ->except(['show']);

// Language
Route::resource('/languages', 'LanguageController')
    ->except(['show']);

// User
Route::resource('/users', 'UserController')
    ->except(['show']);

// Administration
Route::get('/administration/statistics', 'AdministrationController@statistics')
    ->name('administration.statistics');
Route::get('/administration/settings', 'AdministrationController@settings')->name('administration.settings');
Route::post('/administration/settings', 'AdministrationController@updateSettings')
    ->name('administration.update-settings');
Route::get('/administration/logs', 'AdministrationController@logs')->name('administration.logs');

// Secret
Route::get('/account/secrets', 'SecretController@index')->name('account-secrets.index');
Route::get('/account/secrets/create', 'SecretController@create')->name('account-secrets.create');
Route::post('/account/secrets', 'SecretController@store')->name('account-secrets.store');
Route::delete('/account/secrets/{secret}', 'SecretController@revoke')->name('account-secrets.revoke');

// Preferences
Route::get('/account/preferences', 'AccountController@preferences')->name('account.preferences');
Route::post('/account/preferences', 'AccountController@updatePreferences')->name('account.update-preferences');
Route::get('/account/change-password', 'AccountController@changePassword')->name('account.change-password');
Route::post('/account/change-password', 'AccountController@updatePassword')->name('account.update-password');
