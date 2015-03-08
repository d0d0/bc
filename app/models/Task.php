<?php

/**
 * Description of Task
 *
 * @author Jozef Dúc
 */
class Task extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait,
        \Watson\Validating\ValidatingTrait;

    protected $table = 'tasks';
    protected $fillable = array(
        'subject_id',
        'name',
        'text',
        'start',
        'deadline',
        'groupsize',
        'created_at',
        'updated_at'
    );
    protected $rules = array(
        'name' => 'required',
        'start' => 'required|date',
        'deadline' => 'required|date|after:start',
        'groupsize' => 'required|integer|min:1"',
        'text' => 'required',
    );

    public function subject() {
        return $this->hasOne('Subject', 'id', 'subject_id');
    }

    public function scopeAfterStart($query) {
        return $query->whereRaw('start < now()');
    }

    public function scopeAfterDeadline($query) {
        return $query->whereRaw('deadline > now()');
    }

    public function isAfterDeadline() {
        return $this->deadline < Carbon::now();
    }

    public function formattedStart() {
        return Carbon::parse($this->start)->format('d.m.Y H:i');
    }

    public function formattedDeadline() {
        return Carbon::parse($this->deadline)->format('d.m.Y H:i');
    }

    public function files() {
        return TaskFile::where('task_id', '=', $this->id);
    }
    
    public function blocks(){
        return Block::where('task_id', '=', $this->id);
    }

}
