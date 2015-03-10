<?php

/**
 * Description of File
 *
 * @author Jozef
 */
class SolutionFile extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'files';
    protected $fillable = array(
        'group_id',
        'task_id',
        'name',
        'text',
        'version',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'name' => 'required',
        'task_id' => 'required|exists:tasks,id',
        'group_id' => 'required|exists:groups,id'
    );

}
