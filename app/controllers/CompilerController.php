<?php

/**
 * Description of CompilerController
 *
 * @author Jozef
 */
class CompilerController {

    public function run() {
        File::delete('/home/pi/gtest-svn/samples/');
        File::put('/var/www/test.html', '');
        return View::make('compiler.compiler');
    }

}
