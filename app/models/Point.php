<?php

/**
 * Description of Point
 *
 * @author Jozef
 */
class Point extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait,
        \Watson\Validating\ValidatingTrait;

    protected $table = 'points';
    protected $fillable = array(
        'group_id',
        'task_id',
        'points',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'group_id' => 'required|exists:groups,id',
        'task_id' => 'required|exists:tasks,id',
    );

}
