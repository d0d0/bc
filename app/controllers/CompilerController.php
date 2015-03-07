<?php

/**
 * Description of CompilerController
 *
 * @author Jozef
 */
class CompilerController extends BaseController {

    public function run() {
        if (File::exists('/home/pi/gtest-svn/samples/main')) {
            File::delete('/home/pi/gtest-svn/samples/main');
        }
        if (File::exists('/var/www/test.html')) {
            File::delete('/var/www/test.html');
        }
        File::put('/var/www/test.html', '');
        return View::make('compiler.compiler');
    }

}
