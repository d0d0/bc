<?php

/**
 * Description of SolutionController
 *
 * @author Jozef Dúc
 */
class SolutionController extends BaseController {

    public function show($id = null) {
        return View::make('editor.editor');
    }

    public function deletedFiles() {
        $files = Solution::where('task_id', '=', Input::all()['id'])->where('deleted', '=', Solution::DELETED)->get();
        return View::make('subject.deleted', array(
                    'files' => $files
        ));
    }

    public function deleteFile() {
        $file = Solution::where('id', '=', Input::all()['id']);
        $file->deleted = Solution::DELETED;
        $file->save();
        return Response::json(array(
                    'result' => true
        ));
    }

    public function addFile() {
        $node_id = str_random(64);
    }

}
