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
            $path = storage_path() . '/' . $input['task_id'] . $input['group_id'];
            if (!File::exists($path)) {
                File::makeDirectory($path);
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
                $includefiles .= $path . '/' . $file['name'] . ' ';
                File::put($path . '/' . $file['name'], $file['text']);
            }
            $testfile = TestFileGenerator::generate($input['task_id'], $input['group_id']);
            File::put($path . '/test.html', '');
            echo shell_exec('g++ -I/home/jduc/gtest-1.7.0/include -L/home/jduc/gtest-1.7.0/ /home/jduc/gtest-1.7.0/src/gtest_main.cc ' . $includefiles . ' ' . $testfile . ' -lgtest -lpthread -o ' . $path . '/main 2>&1 1>/dev/null');
            shell_exec($path . '/main --gtest_color=yes | sh /home/jduc/gtest-1.7.0/samples/ansi2html.sh > ' . $path . '/test.html');
            return View::make('compiler.compiler', array(
                        'path' => $path
            ));
        }
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
