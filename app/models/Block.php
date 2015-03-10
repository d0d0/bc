<?php

/**
 * Description of Block
 *
 * @author Jozef
 */
class Block extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait,
        \Watson\Validating\ValidatingTrait;

    protected $table = 'blocks';
    protected $fillable = array(
        'task_id',
        'name',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'name' => 'required',
        'task_id' => 'required|exists:tasks,id'
    );

    public function sections() {
        return Section::where('block_id', '=', $this->id);
    }

}
