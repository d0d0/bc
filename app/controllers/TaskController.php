<?php

/**
 * Description of TaskController
 *
 * @author Jozef Dúc
 */
class TaskController extends BaseController {

    function show($id = null) {
        return View::make('task.show');
    }

}
