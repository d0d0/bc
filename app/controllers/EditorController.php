<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EditorController
 *
 * @author Jozef Dúc
 */
class EditorController extends BaseController {
    
    public function show($id = null){
        return View::make('editor.editor');
    }
}
