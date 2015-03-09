<?php

/**
 * Description of CompilerController
 *
 * @author Jozef
 */
class CompilerController extends BaseController {

    public function run() {
        if (File::exists('/home/jduc/gtest-svn/samples/main')) {
            File::delete('/home/jduc/gtest-svn/samples/main');
        }
        if (File::exists(storage_path() . '/test.html')) {
            File::delete(storage_path() . '/test.html');
        }
        File::put(storage_path() . '/test.html', '');
        return View::make('compiler.compiler');
    }

}
