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
                            ->with('message', 'Predmet vytvorený');
        }
        return Redirect::back()
                        ->withErrors($subject->getErrors())
                        ->withInput($input);
    }

    public function manage() {
        if ($subject = Auth::user()->lastSubject) {
            return View::make('subject.manage', array(
                        'subject' => $subject
            ));
        }
        return Redirect::action('SubjectController@create');
    }

    public function getUsers() {
        if (Request::ajax()) {
            $subject = Auth::user()->lastSubject;
            $participants = $subject->participants;
            $result = [];
            foreach ($participants as $participant) {
                $user = $participant->user;
                $result[] = [
                    'id' => $user->id,
                    'name' => $user->getFullName(),
                    'state' => $participant->state
                ];
            }
            return Response::json($result);
        }
    }

    public function updateUser() {
        if (Request::ajax()) {
            $input = Input::all();
            $participant = Participant::where('subject_id', '=', Auth::user()->lastSubject->id)->where('user_id', '=', $input['user_id'])->first();
            $user = User::find($input['user_id']);
            if ($user->lastSubject && $user->lastSubject->id == Auth::user()->lastSubject->id) {
                $user->last_subject = 0;
                $user->save();
            }
            $participant->state = $input['state'];
            $participant->save();
        }
    }

    public function join() {
        return View::make('subject.join');
    }

    public function getSubjects() {
        if (Request::ajax()) {
            $result = [];
            foreach (Subject::all() as $subject) {
                if (!$subject->isActive()) {
                    continue;
                }
                $participant = Participant::where('subject_id', '=', $subject->id)->where('user_id', '=', Auth::id())->first();
                if ($participant) {
                    switch ($participant->state) {
                        case Participant::CREATED:
                            $state = 'Zatiaľ nekontrolovaný';
                            break;
                        case Participant::ACCEPTED:
                            $state = 'Prijatý na predmet';
                            break;
                        case Participant::BLOCKED:
                            $state = 'Odmietnutý na predmet';
                            break;
                    }
                } else {
                    $state = '';
                }
                $result[] = [
                    'id' => $subject->id,
                    'name' => $subject->name,
                    'state' => $state
                ];
            }
            return Response::json($result);
        }
    }

    public function joinSubject() {
        if (Request::ajax()) {
            $input = Input::all();
            $participant = Participant::create(array(
                        'subject_id' => $input['subject_id'],
                        'user_id' => Auth::id()
            ));
            $participant->save();
        }
    }

}
