<?php

/**
 * Description of Anketa
 *
 * @author Jozef
 */
class Anketa extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'anketa';
    protected $fillable = array(
        'user_id',
        'question1',
        'question2',
        'question3',
        'question4',
        'question5',
        'question6',
        'question7',
        'question8',
        'created_at',
        'updated_at'
    );

}
