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
        if ($task->isAfterDeadline()) {
            if ($has_group) {
                $files = SolutionFile::where('group_id', '=', $group_id)
                                ->where(function($query) use($group_id) {
                                    return $query->where('version', '=', SolutionFile::where('group_id', '=', $group_id)->max('version'));
                                })->get();
            } else {
                $files = TaskFile::where('task_id', '=', $id)->get();
            }
            return View::make('editor.code', array(
                        'files' => $files,
                        'task' => $task,
                        'group_id' => $group_id
            ));
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
            $version = DB::table('files')->where('group_id', '=', $input['group_id'])->max('version');
            if ($version == NULL) {
                $version = 0;
            }
            foreach ($input['files'] as $file) {
                $filedata = array(
                    'task_id' => $input['task_id'],
                    'group_id' => $input['group_id'],
                    'name' => $file['name'],
                    'text' => $file['text'],
                    'version' => ($version + 1),
                );
                (new SolutionFile($filedata))->save();
                $includefiles .= $path . '/' . $file['name'] . ' ';
                File::put($path . '/' . $file['name'], $file['text']);
            }
            $testfile = TestFileGenerator::generate($input['task_id'], $input['group_id']);
            shell_exec('cp ' . storage_path() . '/test -r ' . $path);
            $error = shell_exec('g++ -I/home/jduc/gtest-1.7.0/include -L/home/jduc/gtest-1.7.0/ /home/jduc/gtest-1.7.0/src/gtest_main.cc ' . $includefiles . ' ' . $testfile . ' -lgtest -lpthread -std=c++11 -o ' . $path . '/test/tmp/main.out 2>&1 1>/dev/null');
            if ($error) {
                $error = str_replace($path, '', $error);
                try {
                    File::deleteDirectory($path);
                } catch (Exception $e) {
                    
                }
                return '<pre style="color: red">' . $error . '</pre>';
            }
            shell_exec('timeout 7s linux rootfstype=hostfs uml_dir=' . $path . ' rootflags=' . $path . '/test rw mem=48M > ' . $path . '/test/tmp/log 2>&1; echo $?>' . $path . 'test/tmp/exitcode.err');
            if (File::exists($path . '/test/tmp/s.xml')) {
                $result = File::get($path . '/test/tmp/s.xml');
                $parsed = Parser::xml($result);
                $result = "";
                $points = 0;
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
                            $task = Task::find($input['task_id']);
                            $block = $task->blocks()->get(['id'])->toArray();
                            $section = Section::whereIn('block_id', $block)->where('name', '=', $suite['testcase']['@attributes']['name'])->first();
                            $points+= $section->points;
                            $result .= '<strong>' . $section->points . ' bodov</strong><pre style="color: green">Všetko ok</pre>';
                        }
                    }
                }
                if ($point = Point::where('task_id', '=', $input['task_id'])->where('group_id', '=', $input['group_id'])->first()) {
                    $point->points = $points;
                } else {
                    $point = Point::create(array(
                                'task_id' => $input['task_id'],
                                'group_id' => $input['group_id'],
                                'points' => $points
                    ));
                }
                $point->save();
            } else {
                $result = '<pre style="color: red">Time limit. Skontroluj nekonečné while cykly alebo neefektívny algoritmus.</pre>';
            }
            $result = str_replace($path, '', $result);
            try {
                File::deleteDirectory($path);
            } catch (Exception $e) {
                
            }
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
