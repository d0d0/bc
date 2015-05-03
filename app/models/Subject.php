<?php

/**
 * Description of Subject
 *
 * @author Jozef Dúc
 */
class Subject extends Eloquent {

    use \Venturecraft\Revisionable\RevisionableTrait,
        \Watson\Validating\ValidatingTrait;

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
    protected $rules = array(
        'name' => 'required',
        'year' => 'required|integer|min:2010',
        'session' => 'required|in:0,1',
        'teacher' => 'required|exists:users,id,teacher,1'
    );

    public function sessionString() {
        return $this->session == self::WINTER ? 'Zima' : 'Leto';
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
        if (Auth::user()->isTeacher()) {
            return $query->where('subjects.id', '<>', Auth::user()->last_subject);
        }
        return $query->where('subjects.id', '<>', Auth::user()->last_subject)->whereIn('subjects.id', Participant::where('user_id', '=', Auth::id())->where('state', '=', Participant::ACCEPTED)->get(['subject_id'])->toArray());
    }

    public function participants() {
        return $this->hasMany('Participant', 'subject_id', 'id');
    }

    public function isActive() {
        $now = Carbon::now();
        if ($this->session == self::WINTER) {
            $dateFrom = Carbon::createFromDate($this->year, 9, 1);
            $dateTo = Carbon::createFromDate($this->year + 1, 2, 1);
        } else {
            $dateFrom = Carbon::createFromDate($this->year + 1, 1, 1);
            $dateTo = Carbon::createFromDate($this->year + 1, 7, 1);
        }
        return $dateFrom <= $now && $now <= $dateTo;
    }

}
