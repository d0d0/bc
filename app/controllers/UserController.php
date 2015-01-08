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

}
