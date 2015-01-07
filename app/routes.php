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

Route::get('/editor/{id?}', 'EditorController@show');

Route::group(array('prefix' => 'task'), function() {
    Route::get('/all', 'TaskController@all');
    Route::get('/show/{id?}', 'TaskController@show');
    Route::get('/create', 'TaskController@create');
});

Route::group(array('prefix' => 'subject'), function() {
    Route::get('/all', 'SubjectController@all');
    Route::get('/show/{id?}', 'SubjectController@show');
    Route::get('/create', 'SubjectController@create');
    Route::post('/add', 'SubjectController@add');
});
