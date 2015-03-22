@extends('layouts.center_content')

@section('center')
<div class="col-md-6 col-md-offset-3">
    {{ Form::open(array('action' => 'SubjectController@add', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}
    <div class="form-group thumbnail">
        <div class="form-group {{ $errors->has('name') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('name', 'Názov predmetu') }}
            </div>
            <div class="col-md-9">
                {{ Form::text('name', '', array('class'=>'form-control', 'placeholder' => 'Názov predmetu')) }}
                {{ Form::errorMsg('name') }}
            </div>
        </div>
        <div class="form-group {{ $errors->has('year') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('year', 'Rok') }}
            </div>
            <div class="col-md-9">
                {{ Form::text('year', '', array('class'=>'form-control', 'placeholder' => 'Rok')) }}
                {{ Form::errorMsg('year') }}
            </div>
        </div>
        <div class="form-group {{ $errors->has('session') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('session', 'Semester') }}
            </div>
            <div class="col-md-9">
                {{ Form::select('session', array(
                            Subject::WINTER => 'zimný',
                            Subject::SUMMER => 'letný'),
                    '', array('class' => 'form-control')) }}
                {{ Form::errorMsg('session') }}
            </div>
        </div>
        <div class="form-group {{ $errors->has('teacher') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('teacher', 'Učiteľ') }}
            </div>
            <div class="col-md-9">
                <select id="teacher" name="teacher" class="form-control">
                    @foreach(User::teachers()->orderBy('surname')->get() as $user)
                        <option value="{{ $user->id }}" @if($user-id == Auth::id()) selected @endif>{{{ $user->getSurnameName() }}}</option>
                    @endforeach
                </select>
                {{ Form::errorMsg('teacher') }}
            </div>
        </div>
        {{Form::submit('Vytvor', array('class'=>'btn btn-default'))}}
    </div>
    {{ Form::close() }}
</div>
@stop