<?php

class HomeController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    public function showWelcome() {
        dd(shell_exec('gource -1024x768 --stop-position 1.0 --highlight-all-users --hide-filenames --seconds-per-day 5 --output-framerate 60 --a 1'));
        return View::make('login');
    }

}
