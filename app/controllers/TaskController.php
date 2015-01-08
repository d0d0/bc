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
            $rules = array(
                'name' => 'required',
                'start' => 'required|date_format:"d.m.Y H:i"',
                'deadline' => 'required|date_format:"d.m.Y H:i"',
                'text' => 'required',
                'test' => 'required',
            );
            $validator = Validator::make($input, $rules);
            if ($validator->passes()) {
                $input['subject_id'] = Auth::user()->last_subject;
                $input['start'] = date('Y-m-d H:i', strtotime($input['start']));
                $input['deadline'] = date('Y-m-d H:i', strtotime($input['deadline']));
                Task::create($input);
                return Response::json($input);
            }
        }
        return Response::json(array(
                    'result' => false
        ));
    }

}
