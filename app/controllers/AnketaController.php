<?php

/**
 * Description of AnketaController
 *
 * @author Jozef
 */
class AnketaController extends BaseController {

    public function getAnketa() {
        return View::make('anketa.show');
    }

    public function postAnketa() {
        $input = Input::all();
        if (Anketa::where('user_id', '=', Auth::id())->get()->count() > 0) {
            return Redirect::back()
                            ->with('error', Lang::get('Už si raz hlasoval, ale ďakujem za snahu :)'));
        }
        $input['user_id'] = Auth::id();
        (new Anketa($input))->save();
        return Redirect::back()
                        ->with('message', Lang::get('Ďakujem za reakciu'));
    }

}
