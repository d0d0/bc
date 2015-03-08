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
