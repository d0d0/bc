<?php

/**
 * Controller, ktorý obsluhuje užívateľa
 */
class LoginController extends Controller {

    /**
     * Odhlási užívateľa
     * @return type
     */
    public function getLogout() {
        Auth::logout();
        return Redirect::action('HomeController@showWelcome')
                        ->with('message', Lang::get('Odhlásenie prebehlo úspešne'));
    }

    /**
     * Zobrazí prihasovaciu obrazovku
     * @return type
     */
    public function getLogin() {
        return View::make('login');
    }

    /**
     * Pokúsi sa prihlásiť užívateľa
     * @return type
     */
    public function postLogin() {
        $input = Input::only(
                        'email', 'password'
        );
        $rules = array(
            'email' => 'required|email|exists:users,email', //TODO: ,confirmed,1',
            'password' => 'required|min:6'
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator)
                            ->withInput(Input::except('password'))
                            ->with('error', Lang::get('Nepodarilo sa prihlásenie'));
        }
        if (Auth::attempt(array(
                    'email' => Input::get('email'),
                    'password' => Input::get('password'),
                        //TODO: 
                        //'confirmed' => 1
                        ), Input::get('remember'))) {
            return Redirect::action('HomeController@showWelcome')
                            ->with('message', Lang::get('Prihlásenie prebehlo úspešne.'));
        }
        return Redirect::back()
                        ->withErrors($validator)
                        ->withInput(Input::except('password'));
    }

}
