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
        exec('g++ /var/www/main.cpp -o /var/www/programname.out >& /var/www/error.log', $result);
        if($result){
            dd($result);
        }
        dd(file_exists('/var/ww/error.log'));
        if(file_exists('/var/ww/error.log')){
            $myfile = fopen("/var/ww/error.log", "r");
            $content = fread($myfile,filesize("/var/ww/error.log"));
            fclose($myfile);
            dd($content);
        }
        exec('/var/www/programname.out', $result);
        dd($result);
        return View::make('login');
    }

}
