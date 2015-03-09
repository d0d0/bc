{{ shell_exec('g++ -I/home/jduc/gtest-svn/include -L/home/jduc/gtest-svn/ /home/jduc/gtest-svn/src/gtest_main.cc /home/jduc/gtest-svn/samples/sample1.cc /home/jduc/gtest-svn/samples/sample1_unittest.cc -lgtest -lpthread -o /home/jduc/gtest-svn/samples/main 2>&1 1>/dev/null') }}
{{ shell_exec('/home/jduc/gtest-svn/samples/main --gtest_color=yes | sh /home/jduc/gtest-svn/samples/ansi2html.sh > /var/www/test.html') }}
{{ File::get('/var/www/test.html') }}
.Info o komjduclátore
{{ shell_exec('g++ --version') }}