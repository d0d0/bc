<?php

/**
 * Description of Test
 *
 * @author Jozef
 */
class Test extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait,
        \Watson\Validating\ValidatingTrait;

    const EQUAL = 0;
    const NON_EQUAL = 1;

    protected $table = 'tests';
    protected $fillable = array(
        'section_id',
        'codebefore',
        'testfunction',
        'compare',
        'expected',
        'codeafter',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'section_id' => 'required|exists:sections,id',
        'testfunction' => 'required',
        'compare' => 'required|in:0,1',
        'expected' => 'required'
    );

}
