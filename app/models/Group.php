<?php

/**
 * Description of Group
 *
 * @author Jozef Dúc
 */
class Group extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'groups';
    protected $fillable = array('name', 'created_at', 'updated_at');
    
    public function members(){
        return User::whereIn('id', GroupMembers::where('group_id', '=', $this->id)->select('user_id')->get()->toArray());
    }

}
