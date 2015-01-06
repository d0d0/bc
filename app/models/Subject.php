<?php

/**
 * Description of Subject
 *
 * @author Jozef Dúc
 */
class Subject extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    const WINTER = 0;
    const SUMMER = 1;

    protected $table = 'subjects';
    protected $fillable = array('name', 'year', 'session', 'teacher', 'created_at', 'updated_at');

    public function teacher() {
        return $this->hasOne('User', 'id', 'teacher');
    }

}
