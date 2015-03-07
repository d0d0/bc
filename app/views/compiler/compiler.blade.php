{{ shell_exec('g++ -I/home/pi/gtest-svn/include -L/home/pi/gtest-svn/ /home/pi/gtest-svn/src/gtest_main.cc /home/pi/gtest-svn/samples/sample1.cc /home/pi/gtest-svn/samples/sample1_unittest.cc -lgtest -lpthread -o /home/pi/gtest-svn/samples/main 2>&1 1>/dev/null') }}
{{ shell_exec('/home/pi/gtest-svn/samples/main --gtest_color=yes | sh /home/pi/gtest-svn/samples/ansi2html.sh > /var/www/test.html') }}
{{ File::get('/var/www/test.html') }}
.Info o kompilátore
{{ shell_exec('g++ --version') }}