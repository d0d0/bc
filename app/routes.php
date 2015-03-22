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

Route::post('/register', 'RegistrationController@postRegister');
Route::get('/register', 'RegistrationController@getRegister');

Route::get('/compiler', 'CompilerController@run');

Route::group(array('before' => 'guest'), function() {
    Route::get('/login', 'LoginController@getLogin');
    Route::post('/login', 'LoginController@postLogin');

    Route::get('/remind', 'RemindersController@getRemind');
    Route::post('/remind', 'RemindersController@postRemind');
    Route::get('/reset/{token?}', 'RemindersController@getReset');
    Route::post('/reset/{token?}', 'RemindersController@postReset');
});


Route::group(array('before' => 'auth'), function() {
    Route::group(array('prefix' => 'user'), function() {
        Route::get('/show/{id?}', 'UserController@show');
        Route::get('/setSubject/{id?}', 'UserController@setSelectedSubject');
        Route::get('/logout', 'LoginController@getLogout');
    });

    Route::group(array('prefix' => 'solution'), function() {
        Route::get('/show/{id?}', 'SolutionController@show');
        Route::post('/add', 'SolutionController@add');
        Route::group(array('before' => 'csrf'), function() {
            Route::post('/getText', 'SolutionController@getText');
            Route::post('/addTest', 'SolutionController@addOwnTest');
            Route::post('/getTest', 'SolutionController@getOwnTest');
            Route::post('/deleteTest', 'SolutionController@deleteOwnTest');
        });
    });

    Route::group(array('prefix' => 'task'), function() {
        Route::get('/all', 'TaskController@all');
        Route::get('/show/{id?}', 'TaskController@show');
        Route::group(array('before' => 'teacher'), function() {
            Route::get('/create', 'TaskController@create');
            Route::get('/edit/{id?}', 'TaskController@edit');
            Route::group(array('before' => 'csrf'), function() {
                Route::post('/add', 'TaskController@add');
            });
        });
    });

    Route::group(array('prefix' => 'subject'), function() {
        Route::get('/all', 'SubjectController@all');
        Route::get('/show/{id?}', 'SubjectController@show');
        Route::group(array('before' => 'teacher'), function() {
            Route::get('/create', 'SubjectController@create');
            Route::group(array('before' => 'csrf'), function() {
                Route::post('/add', 'SubjectController@add');
            });
        });
    });

    Route::group(array('prefix' => 'group'), function() {
        Route::get('/show/{id?}', 'GroupController@show');
        Route::get('/create/{id?}', 'GroupController@create');
        Route::group(array('before' => 'csrf'), function() {
            Route::post('/groups', 'GroupController@groups');
            Route::post('/groupsCreate', 'GroupController@createGroup');
            Route::post('/delete', 'GroupController@delete');
            Route::post('/join', 'GroupController@join');
            Route::post('/leave', 'GroupController@leave');
            Route::post('/approve', 'GroupController@approve');
        });
    });
});
