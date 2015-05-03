<?php

/**
 * Description of Participant
 *
 * @author Jozef Dúc
 */
class Participant extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    const CREATED = 0;
    const ACCEPTED = 1;
    const BLOCKED = 2;

    protected $table = 'participants';
    protected $fillable = array(
        'user_id',
        'subject_id',
        'state',
        'created_at',
        'updated_at'
    );

    public function user() {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function subject() {
        return $this->hasOne('Subject', 'id', 'subject_id');
    }

}
