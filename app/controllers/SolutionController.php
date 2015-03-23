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
                return '<pre style="color: red">' . $error . '<pre>';
            }
            shell_exec('timeout 5s ' . $path . '/main --gtest_color=yes --gtest_output=xml:' . $path . '/s.xml | sh /home/jduc/gtest-1.7.0/samples/ansi2html.sh > ' . $path . '/test.html');

            $result = File::get($path . '/.xml');
            $parsed = Parser::xml($result);
            $result = "";
            $error = false;
            foreach ($parsed['testsuite'] as $suite) {
                $suiteError = false;
                foreach ($suite['testcase'] as $testCase) {
                    if (isset($testCase['failure'])) {
                        if (isset($testCase['failure'][0])) {
                            $result .= $testCase['failure'][0]['@attributes']['message'];
                        } else {
                            $result .= $testCase['failure']['@attributes']['message'];
                        }
                        $suiteError = true;
                        break;
                    }
                }
            }
            File::deleteDirectory($path);
            return $result;
            return View::make('compiler.compiler', array(
                        'path' => $path
            ));
        }
    }

    public function getText() {
        return Response::json(Solution::where('node_id', '=', Input::get('node_id'))->select('text')->get());
    }

    public function getOwnTests() {
        if (Request::ajax()) {
            return Response::json();
        }
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
