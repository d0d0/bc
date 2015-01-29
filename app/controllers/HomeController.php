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
        /* exec('g++ /var/www/main.cpp -o /var/www/programname.out >& /var/www/error.log', $result);
          if ($result) {
          dd($result);
          }
          if (file_exists('/var/www/error.log')) {
          $myfile = fopen("/var/www/error.log", "r");
          $content = fread($myfile, filesize("/var/www/error.log"));
          fclose($myfile);
          dd($content);
          }
          exec('/var/www/programname.out', $result);
          dd($result);
         */
        File::put('/var/www/test.html', '');
        exec('/home/pi/gtest-svn/samples/main --gtest_color=yes | sh /home/pi/gtest-svn/samples/ansi2html.sh > /var/www/test.html');

        if (Auth::check()) {
            return Redirect::action('TaskController@all');
        }
        return View::make('login');
    }

}
