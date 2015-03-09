<?php

/**
 * Description of TaskFile
 *
 * @author Jozef
 */
class TaskFile extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait,
        \Watson\Validating\ValidatingTrait;

    protected $table = 'task_files';
    protected $fillable = array(
        'task_id',
        'name',
        'text',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'task_id' => 'required|exists:tasks,id',
        'name' => 'required',
        'text' => 'required',
    );

}
