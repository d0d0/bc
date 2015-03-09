{{ shell_exec('g++ -I/home/jduc/gtest-1.7.0/include -L/home/jduc/gtest-1.7.0/ /home/jduc/gtest-1.7.0/src/gtest_main.cc /home/jduc/gtest-1.7.0/samples/sample1.cc /home/jduc/gtest-1.7.0/samples/sample1_unittest.cc -lgtest -lpthread -o /home/jduc/gtest-1.7.0/samples/main 2>&1 1>/dev/null') }}
{{ shell_exec('/home/jduc/gtest-1.7.0/samples/main --gtest_color=yes | sh /home/jduc/gtest-1.7.0/samples/ansi2html.sh > '.storage_path().'/test.html') }}
{{ File::get(storage_path().'/test.html') }}
.Info o kompilátore
{{ shell_exec('g++ --version') }}