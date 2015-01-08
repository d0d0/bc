<?php

/**
 * Description of UserController
 *
 * @author Jozef Dúc
 */
class UserController extends BaseController {

    public function show($id = null) {
        $user = User::find($id) ? User::find($id) : Auth::user();
        return View::make('user.show', array(
                    'user' => $user
        ));
    }

    public function setSelectedSubject($id = null) {
        if ($id) {
            Auth::user()->last_subject = $id;
            Auth::user()->save();
        }
        return Redirect::action('HomeController@showWelcome');
    }

}
