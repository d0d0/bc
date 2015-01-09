<?php

/**
 * Description of GroupController
 *
 * @author Jozef Dúc
 */
class GroupController {

    public function show($id = null) {
        return View::make('group.show');
    }

    public function all() {
        return View::make('group.all');
    }

    public function create() {
        return View::make('group.create');
    }

}
