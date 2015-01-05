<?php

/**
 * Description of Subject
 *
 * @author Jozef Dúc
 */
class Subject extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'subjects';
    protected $fillable = array('name', 'teacher', 'created_at', 'updated_at');

    public function teacher() {
        return $this->hasOne('User', 'id', 'teacher');
    }

}
