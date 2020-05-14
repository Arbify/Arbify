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

Route::resource('/projects', 'ProjectController')
    ->except(['show']);

Route::get('/projects/{project}/add-language', 'ProjectController@addLanguage')
    ->name('projects.add-language');

Route::post('/projects/{project}/add-language', 'ProjectController@postAddLanguage')
    ->name('projects.post-add-language');

Route::post('/projects/{project}/messages/{message}/{languageCode}', 'MessageController@storeValue')
    ->name('messages.store-value');

Route::resource('/projects/{project}/messages', 'MessageController')
    ->except(['show']);

Route::resource('/languages', 'LanguageController')
    ->except(['show']);
