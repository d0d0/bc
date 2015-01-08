<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('/', 'HomeController@showWelcome');

Route::get('/login', 'LoginController@getLogin');
Route::post('/login', 'LoginController@postLogin');
Route::get('/logout', 'LoginController@getLogout');

Route::get('/remind', 'RemindersController@getRemind');
Route::post('/remind', 'RemindersController@postRemind');
Route::get('/reset/{token?}', 'RemindersController@getReset');
Route::post('/reset/{token?}', 'RemindersController@postReset');


Route::group(array('prefix' => 'user'), function() {
    Route::get('/show/{id?}', 'UserController@show');
    Route::get('/setSubject/{id?}', 'UserController@setSelectedSubject');
});

Route::group(array('prefix' => 'solution'), function() {
    Route::get('/show/{id?}', 'SolutionController@show');
    Route::post('/deletedFiles', 'SolutionController@deletedFiles');
    Route::post('/addFile', 'SolutionController@addFile');
    Route::post('/deleteFile', 'SolutionController@deleteFile');
});

Route::group(array('prefix' => 'task'), function() {
    Route::get('/all', 'TaskController@all');
    Route::get('/show/{id?}', 'TaskController@show');
    Route::get('/create', 'TaskController@create');
    Route::post('/add', 'TaskController@add');
});

Route::group(array('prefix' => 'subject'), function() {
    Route::get('/all', 'SubjectController@all');
    Route::get('/show/{id?}', 'SubjectController@show');
    Route::get('/create', 'SubjectController@create');
    Route::post('/add', 'SubjectController@add');
});
