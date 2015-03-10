<?php

/**
 * Description of CompilerController
 *
 * @author Jozef
 */
class CompilerController extends BaseController {

    public function run() {
        echo(TestFileGenerator::generate(1));
        if (File::exists('/home/jduc/gtest-1.7.0/samples/main')) {
            File::delete('/home/jduc/gtest-1.7.0/samples/main');
        }
        if (File::exists(storage_path() . '/test.html')) {
            File::delete(storage_path() . '/test.html');
        }
        File::put(storage_path() . '/test.html', '');
        shell_exec('g++ -I/home/jduc/gtest-1.7.0/include -L/home/jduc/gtest-1.7.0/ /home/jduc/gtest-1.7.0/src/gtest_main.cc /home/jduc/gtest-1.7.0/samples/sample1.cc /home/jduc/gtest-1.7.0/samples/sample1_unittest.cc -lgtest -lpthread -o /home/jduc/gtest-1.7.0/samples/main 2>&1 1>/dev/null');
        shell_exec('/home/jduc/gtest-1.7.0/samples/main --gtest_color=yes | sh /home/jduc/gtest-1.7.0/samples/ansi2html.sh > ' . storage_path() . '/test.html');
        return View::make('compiler.compiler');
    }

}
