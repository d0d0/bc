<?php

/**
 * Description of TaskFile
 *
 * @author Jozef
 */
class TaskFile extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait,
        \Watson\Validating\ValidatingTrait;

    const HEADER = 1;
    const CPP = 0;

    protected $table = 'task_files';
    protected $fillable = array(
        'task_id',
        'name',
        'header',
        'text',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'task_id' => 'required|exists:tasks,id',
        'name' => 'required',
        'header' => 'required|in:0,1',
        'text' => 'required',
    );

    public function scopeHeader($query) {
        return $query->where('header', '=', self::HEADER);
    }

    public function scopeCpp($query) {
        return $query->where('header', '=', self::CPP);
    }

}
