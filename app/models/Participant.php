<?php

/**
 * Description of Participant
 *
 * @author Jozef Dúc
 */
class Participant extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'participants';
    protected $fillable = array('user_id', 'subject_id', 'created_at', 'updated_at');

    public function User() {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function Subject() {
        return $this->hasOne('Subject', 'id', 'subject_id');
    }

}
