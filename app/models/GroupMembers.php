<?php

/**
 * Description of GroupMembers
 *
 * @author Jozef Dúc
 */
class GroupMembers extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'group_members';
    protected $fillable = array('group_id', 'user_id', 'created_at', 'updated_at');

}
