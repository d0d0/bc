<?php

/**
 * Description of SolutionController
 *
 * @author Jozef Dúc
 */
class SolutionController extends BaseController {

    public function show($id = null) {
        $new = false;
        if (Solution::where('task_id', '=', $id)->get()->isEmpty()) {
            //TODO: upgrade group
            SolutionHelper::addNewFile($id, 1);
            $new = true;
        }
        $files = Solution::where('task_id', '=', $id)->notDeleted()->get();
        $task = Task::find($id);
        if ($task->isAfterDeadline()) {
            return View::make('editor.code', array(
                        'files' => $files,
                        'task' => $task
            ));
        } else {
            return View::make('editor.editor', array(
                        'id' => $id,
                        'files' => $files,
                        'task' => $task,
                        'new' => $new
            ));
        }
    }

    public function add() {
        if (Request::ajax()) {
            $input = Input::all();
            $includefiles = '';
            if (!File::exists(storage_path() . '/' . $input['task_id'] . $input['group_id'])) {
                File::makeDirectory(storage_path() . '/' . $input['task_id'] . $input['group_id']);
            }
            foreach ($input['files'] as $file) {
                $filedata = array(
                    'task_id' => $input['task_id'],
                    'group_id' => $input['group_id'],
                    'name' => $file['name'],
                    'text' => $file['text'],
                    'version' => 1,
                );
                (new SolutionFile($filedata))->save();
                $includefiles .= storage_path() . '/' . $input['task_id'] . $input['group_id'] . '/' . $file['name'] . ' ';
                File::put(storage_path() . '/' . $input['task_id'] . $input['group_id'] . '/' . $file['name'], $file['text']);
            }
            $testfile = TestFileGenerator::generate($input['task_id'], $input['group_id']);
            if (File::exists('/home/jduc/gtest-1.7.0/samples/main')) {
                File::delete('/home/jduc/gtest-1.7.0/samples/main');
            }
            if (File::exists(storage_path() . '/test.html')) {
                File::delete(storage_path() . '/test.html');
            }
            File::put(storage_path() . '/test.html', '');
            shell_exec('g++ -I/home/jduc/gtest-1.7.0/include -L/home/jduc/gtest-1.7.0/ /home/jduc/gtest-1.7.0/src/gtest_main.cc ' . $includefiles . ' ' . $testfile . ' -lgtest -lpthread -o /home/jduc/gtest-1.7.0/samples/main 1>2> ' . storage_path() . '/test.html');
            if (File::size(storage_path() . '/test.html') == 0) {
                shell_exec('/home/jduc/gtest-1.7.0/samples/main --gtest_color=yes | sh /home/jduc/gtest-1.7.0/samples/ansi2html.sh > ' . storage_path() . '/test.html');
            }
            return View::make('compiler.compiler');
        }
    }

    public function getResult() {
        return View::make('compiler.compiler');
    }

    public function deletedFiles() {
        $files = Solution::where('task_id', '=', Input::all()['id'])->where('deleted', '=', Solution::DELETED)->get();
        return View::make('editor.deleted', array(
                    'files' => $files
        ));
    }

    public function getText() {
        return Response::json(Solution::where('node_id', '=', Input::get('node_id'))->select('text')->get());
    }

    public function deleteFile() {
        SolutionHelper::deleteFile(Input::all()['node_id']);
        return Response::json(array(
                    'result' => true
        ));
    }

}
