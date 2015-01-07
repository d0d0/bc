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
    
    public function all(){
        return View::make('task.all');
    }
    
    public function create(){
        return View::make('task.create');
    }

}
