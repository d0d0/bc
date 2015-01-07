<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait,
        \Venturecraft\Revisionable\RevisionableTrait;

    const ADMIN = 1;
    const TEACHER = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');
    protected $fillable = array('login', 'name', 'surname', 'email', 'admin', 'teacher', 'created_at', 'updated_at', 'last_subject');

    public function subjects() {
        return $this->hasMany('Subject', 'teacher', 'id');
    }

    public function getFullName() {
        return $this->name . ' ' . $this->surname;
    }

    public function getSurnameName() {
        return $this->surname . ' ' . $this->name;
    }

    public function getLastSubject() {
        return $this->hasOne('Subject', 'id', 'last_subject');
    }

    public function scopeTeachers($query) {
        return $query->where('teacher', '=', self::TEACHER);
    }

}
