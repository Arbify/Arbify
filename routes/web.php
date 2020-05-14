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

Route::bind('languageCode', function ($value) {
    return \App\Language::where('code', $value)->first();
});

Auth::routes();

Route::get('/', 'DashboardController')->name('dashboard');

Route::resource('/projects', 'ProjectController');

Route::get('/projects/{project}/languages/create', 'ProjectController@createProjectLanguage')
    ->name('projects.languages.create');

Route::post('/projects/{project}/languages', 'ProjectController@storeProjectLanguage')
    ->name('projects.languages.store');

Route::delete('/projects/{project}/languages/{language}', 'ProjectController@destroyProjectLanguage')
    ->name('projects.languages.destroy');

Route::put('/projects/{project}/messages/{message}/{languageCode}', 'MessageController@putMessageValue')
    ->name('messages.values.put');

Route::resource('/projects/{project}/messages', 'MessageController')
    ->except(['show']);

Route::resource('/languages', 'LanguageController')
    ->except(['show']);

Route::resource('/users', 'UserController')
    ->except(['show']);
