<?php

/**
 * Description of Section
 *
 * @author Jozef
 */
class Section extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait,
        \Watson\Validating\ValidatingTrait;

    protected $table = 'sections';
    protected $fillable = array(
        'block_id',
        'name',
        'points',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'name' => 'required',
        'points' => 'required|integer|min:0',
        'block_id' => 'required|exists:blocks,id'
    );

}
