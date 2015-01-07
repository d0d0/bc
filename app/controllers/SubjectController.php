<?php

/**
 * Description of SubjectController
 *
 * @author Jozef
 */
class SubjectController extends BaseController {

    public function show($id = null) {
        return View::make('subject.show');
    }

    public function all() {
        return View::make('subject.all');
    }

    public function create() {
        return View::make('subject.create');
    }

    public function add() {
        $input = Input::all();
        $rules = array(
            'name' => 'required',
            'year' => 'required|integer|min:2010',
            'session' => 'required|in:' . Subject::WINTER . ',' . Subject::SUMMER,
            'teacher' => 'required|exists:users,id,teacher,' . User::TEACHER
        );
        $validator = Validator::make($input, $rules);
        if ($validator->passes()) {
            Subject::create($input);
            return Redirect::action('SubjectController@create')
                            ->with('message', '.Predmet vytvorený');
        }
        return Redirect::back()
                        ->withErrors($validator)
                        ->withInput($input);
    }

}
