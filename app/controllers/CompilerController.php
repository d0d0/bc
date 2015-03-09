<?php

/**
 * Description of CompilerController
 *
 * @author Jozef
 */
class CompilerController extends BaseController {

    public function run() {
        if (File::exists('/home/jduc/gtest-1.7.0/samples/main')) {
            File::delete('/home/jduc/gtest-1.7.0/samples/main');
        }
        if (File::exists(storage_path() . '/test.html')) {
            File::delete(storage_path() . '/test.html');
        }
        File::put(storage_path() . '/test.html', '');
        return View::make('compiler.compiler');
    }

}
