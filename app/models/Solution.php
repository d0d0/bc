<?php

/**
 * Description of Solution
 *
 * @author Jozef Dúc
 */
class Solution extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;

    const EXISTS = 0;
    const DELETED = 1;

    protected $table = 'solutions';
    protected $fillable = array('group_id', 'task_id', 'text', 'name', 'node_id', 'deleted', 'created_at', 'updated_at');

    public function group() {
        return $this->hasOne('Group', 'id', 'group_id');
    }

    public function task() {
        return $this->hasOne('Group', 'id', 'task_id');
    }

    public function scopeNotDeleted($query) {
        return $query->where('deleted', '=', self::EXISTS);
    }

}
