<?php

/**
 * Description of SolutionController
 *
 * @author Jozef Dúc
 */
class SolutionController extends BaseController {

    public function show($id = null) {
        if (!$task = Task::find($id)) {
            return Redirect::action('HomeController@showWelcome');
        }
        $groups = Group::where('task_id', '=', $id)->approved()->get();
        $has_group = false;
        $group_id = 0;
        foreach ($groups as $group) {
            foreach ($group->members()->get() as $user) {
                if ($user->id == Auth::id()) {
                    $has_group = true;
                    $group_id = $group->id;
                    break;
                }
            }
        }
        if (!$has_group) {
            return Redirect::action('GroupController@create', array(
                        'id' => $id
            ));
        }
        $new = false;
        if (Solution::where('task_id', '=', $id)->where('group_id', '=', $group_id)->get()->isEmpty()) {
            SolutionHelper::addNewFile($id, $group_id);
            $new = true;
        }
        $files = Solution::where('task_id', '=', $id)->where('group_id', '=', $group_id)->get();
        if ($task->isAfterDeadline()) {
            return View::make('editor.code', array(
                        'files' => $files,
                        'task' => $task,
                        'group_id' => $group_id
            ));
        }
        return View::make('editor.editor', array(
                    'id' => $id,
                    'files' => $files,
                    'task' => $task,
                    'new' => $new,
                    'group_id' => $group_id
        ));
    }

    public function add() {
        if (Request::ajax()) {
            $input = Input::all();
            $includefiles = '';
            $path = storage_path() . '/' . $input['task_id'] . $input['group_id'];
            if (File::exists($path)) {
                File::deleteDirectory($path);
            }
            File::makeDirectory($path);
            foreach ($input['files'] as $file) {
                $filedata = array(
                    'task_id' => $input['task_id'],
                    'group_id' => $input['group_id'],
                    'name' => $file['name'],
                    'text' => $file['text'],
                    'version' => 1,
                );
                (new SolutionFile($filedata))->save();
                $includefiles .= $path . '/' . $file['name'] . ' ';
                File::put($path . '/' . $file['name'], $file['text']);
            }
            $testfile = TestFileGenerator::generate($input['task_id'], $input['group_id']);
            File::put($path . '/test.html', '');
            $error = shell_exec('g++ -I/home/jduc/gtest-1.7.0/include -L/home/jduc/gtest-1.7.0/ /home/jduc/gtest-1.7.0/src/gtest_main.cc ' . $includefiles . ' ' . $testfile . ' -lgtest -lpthread -o ' . $path . '/main 2>&1 1>/dev/null');
            if ($error) {
                $error = str_replace($path, '', $error);
                return '<pre style="color: red">' . $error . '</pre>';
            }
            shell_exec('timeout 5s ' . $path . '/main --gtest_color=yes --gtest_output=xml:' . $path . '/s.xml | sh /home/jduc/gtest-1.7.0/samples/ansi2html.sh > ' . $path . '/test.html');

            if (File::exists($path . '/s.xml')) {
                $result = File::get($path . '/s.xml');
                $parsed = Parser::xml($result);
                $result = "";
                foreach ($parsed['testsuite'] as $suite) {
                    if (isset($suite['testcase'])) {
                        $result .= 'BLOK: ' . $suite['testcase']['@attributes']['name'] . PHP_EOL;
                        if (isset($suite['testcase']['failure'])) {
                            if (gettype($suite['testcase']['failure']) == 'array') {
                                foreach ($suite['testcase']['failure'] as $case) {
                                    $result .= '<pre style="color: red">' . $case . '</pre>' . PHP_EOL;
                                    if ($suite['testcase']['@attributes']['name'] != 'TESTY') {
                                        break;
                                    }
                                }
                            } else {
                                $result .= '<pre style="color: red">' . $suite['testcase']['failure'] . '</pre>' . PHP_EOL;
                            }
                        } else {
                            $result .= '<pre style="color: green">Všetko ok</pre>';
                        }
                    }
                }
                File::deleteDirectory($path);
            } else {
                $result = '<pre style="color: red">Time limit. Skontroluj nekonečné while cykly alebo neefektívny algortimus.</pre>';
            }
            $result = str_replace($path, '', $result);
            return $result;
        }
    }

    public function getText() {
        return Response::json(Solution::where('node_id', '=', Input::get('node_id'))->select('text')->get());
    }

    public function addOwnTest() {
        if (Request::ajax()) {
            $input = Input::all();
            $ownTest = OwnTest::create($input);
            return Response::json(array(
                        'result' => $ownTest->save()
            ));
        }
        return Response::json(array(
                    'result' => false
        ));
    }

    public function getOwnTest() {
        if (Request::ajax()) {
            $input = Input::all();
            return Response::json(OwnTest::where('group_id', '=', $input['group_id'])->where('task_id', '=', $input['task_id'])->get());
        }
        return Response::json(array(
                    'result' => false
        ));
    }

    public function deleteOwnTest() {
        if (Request::ajax()) {
            $input = Input::all();
            OwnTest::find($input['id'])->delete();
            return Response::json(array(
                        'result' => true
            ));
        }
        return Response::json(array(
                    'result' => false
        ));
    }

}
