<?php

/**
 * Description of GroupController
 *
 * @author Jozef Dúc
 */
class GroupController extends BaseController {

    public function show($id = null) {
        return View::make('group.show');
    }

    public function all() {
        return View::make('group.all');
    }

    public function create($id = null) {
        $tasks = [];
        if (Auth::user()->lastSubject) {
            $subject = Auth::user()->lastSubject;
            $tasks = $subject->task()->afterStart()->orderBy('deadline')->get();
        }
        return View::make('group.create', array(
                    'tasks' => $tasks,
                    'id' => $id
        ));
    }

    public function groups() {
        if (Request::ajax()) {
            $input = Input::all();
            $groups = Group::where('task_id', '=', $input['id'])->get();
            return Response::json($groups);
        }
    }

}
