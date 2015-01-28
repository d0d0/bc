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
        $tasks = [];
        if (Auth::user()->lastSubject) {
            $subject = Auth::user()->lastSubject;
            if (Auth::id() == $subject->teacher()->first()->id) {
                $tasks = $subject->task();
            } else {
                $tasks = $subject->task()->afterStart();
            }
            $tasks = $tasks->orderBy('deadline')->get();
        }
        return View::make('task.all', array(
                    'tasks' => $tasks
        ));
    }

    public function create() {
        return View::make('task.create');
    }

    public function add() {
        if (Request::ajax()) {
            $input = Input::all();
            if (Carbon::createFromFormat('d.m.Y H:i', $input['start']) &&
                    Carbon::createFromFormat('d.m.Y H:i', $input['deadline'])) {
                $input['subject_id'] = Auth::user()->last_subject;
                $input['text'] = str_replace('\'', '', $input['text']);
                $input['start'] = date('Y-m-d H:i', strtotime($input['start']));
                $input['deadline'] = date('Y-m-d H:i', strtotime($input['deadline']));
                $task = new Task($input);
                if ($task->save()) {
                    $input['result'] = true;
                    return Response::json($input);
                }
                return Response::json($task->getErrors());
            }
        }
        return Response::json(array(
                    'result' => false
        ));
    }

}
