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
        'file_name',
        'text',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'task_id' => 'required|exists:tasks,id',
        'file_name' => 'required',
        'text' => 'required',
    );

}
