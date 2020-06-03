<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/projects/{project}/arb', 'Project\ExportController@index')
    ->name('projects.available-exports');
Route::get('/projects/{project}/arb/{language_code}', 'Project\ExportController@show')
    ->name('projects.export');

Route::post('/projects/{project}/import', 'Project\ImportController@import')
    ->name('projects.import');
