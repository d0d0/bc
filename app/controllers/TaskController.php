<?php

/**
 * Description of TaskController
 *
 * @author Jozef Dúc
 */
class TaskController extends BaseController {

    public function show($id = null) {
        return View::make('task.show');
    }

    public function all() {
        return View::make('task.all');
    }

    public function create() {
        return View::make('task.create');
    }

    public function add() {
        if (Request::ajax()) {
            $input = Input::all();
            $input['subject_id'] = Auth::user()->last_subject;
            $input['start'] = date('Y-m-d H:i', strtotime($input['start']));
            $input['deadline'] = date('Y-m-d H:i', strtotime($input['deadline']));
            $task = new Task($input);
            if ($task->save()) {
                $input['result'] = true;
                return Response::json($input);
            }
        }
        return Response::json(array(
                    'result' => false
        ));
    }

}
