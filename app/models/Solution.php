<?php

/**
 * Description of Solution
 *
 * @author Jozef Dúc
 */
class Solution extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $table = 'solutions';
    protected $fillable = array('group_id', 'task_id', 'text', 'name', 'node_id', 'created_at', 'updated_at');

    public function group() {
        return $this->hasOne('Group', 'id', 'group_id');
    }

    public function task() {
        return $this->hasOne('Group', 'id', 'task_id');
    }

}
