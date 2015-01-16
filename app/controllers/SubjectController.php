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
        $subject = new Subject($input);
        if ($subject->save()) {
            return Redirect::action('SubjectController@create')
                            ->with('message', '.Predmet vytvorený');
        }
        return Redirect::back()
                        ->withErrors($subject->getErrors())
                        ->withInput($input);
    }

}
