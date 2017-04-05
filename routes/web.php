<?php

use App\User;

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

Route::get('/', 'Controller@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index');

//route per utenti registrati
Route::group(['middleware' => 'auth'], function () {

    //route per utenti di tipo allievo
    Route::group(['middleware' => 'App\Http\Middleware\Student'], function () {
    });

    //route per utenti di tipo docente
    Route::group(['middleware' => 'App\Http\Middleware\Teacher'], function () {
        Route::resource('assignments', 'AssignmentController');
        Route::resource('assignmentshistory', 'AssignmentHistoryController');
        Route::resource('projects', 'ProjectController');
    });

    //route per utenti di tipo admin
    Route::group(['middleware' => 'App\Http\Middleware\Admin'], function () {
        Route::resource('users', 'UserController');
        Route::resource('types', 'TypeController');
        Route::resource('filetypes', 'FileTypeController');
        Route::resource('ambits', 'AmbitController');
        Route::resource('projectstates', 'ProjectStateController');
    });
});

//route per gli utenti non registrati
Route::resource('currentprojects', 'CurrentProjectController');

Route::get('upload', function() {
    return View::make('currentprojects.upload');
});
Route::post('currentprojects/upload', 'CurrentProjectController@upload');

Route::resource('freeprojects', 'FreeProjectController');

Route::resource('finishedprojects', 'FinishedProjectController');

Route::get('register/verify/{token}','Auth\RegisterController@verify');

