<?php

/**
 * Description of Subject
 *
 * @author Jozef Dúc
 */
class Subject extends Model {

    use \Venturecraft\Revisionable\RevisionableTrait;

    const WINTER = 0;
    const SUMMER = 1;

    protected $table = 'subjects';
    protected $fillable = array(
        'name',
        'year',
        'session',
        'teacher',
        'created_at',
        'updated_at'
    );

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        parent::$rules = array(
            'name' => 'required',
            'year' => 'required|integer|min:2010',
            'session' => 'required|in:' . self::WINTER . ',' . self::SUMMER,
            'teacher' => 'required|exists:users,id,teacher,' . User::TEACHER
        );
    }

    public function sessionString() {
        return $this->session == self::WINTER ? '.Zima' : '.Leto';
    }

    public function bothYears() {
        return $this->year . ' / ' . ($this->year + 1);
    }

    public function teacher() {
        return $this->hasOne('User', 'id', 'teacher');
    }

    public function task() {
        return $this->hasMany('Task', 'subject_id', 'id');
    }

    public function scopeWithoutselected($query) {
        return $query->where('id', '<>', Auth::user()->last_subject);
    }

}
