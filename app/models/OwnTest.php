<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OwnTest
 *
 * @author Jozef
 */
class OwnTest extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait,
        \Watson\Validating\ValidatingTrait;

    const EQUAL = 0;
    const NON_EQUAL = 1;

    protected $table = 'ownTests';
    protected $fillable = array(
        'group_id',
        'task_id',
        'codebefore',
        'testfunction',
        'compare',
        'expected',
        'codeafter',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'group_id' => 'required|exists:groups,id',
        'task_id' => 'required|exists:tasks,id',
        'testfunction' => 'required',
        'compare' => 'required|in:0,1',
        'expected' => 'required'
    );

}
