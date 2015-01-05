@extends('layouts.center_content')

@section('center')
<div class="col-md-6 col-md-offset-3" style="margin-top: 5em">
    {{ Form::open(array('action' => 'LoginController@postLogin', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}
    <div class="form-group thumbnail" type="clanok">
        <div class="form-group {{ $errors->has('email') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('email', '.email') }}
            </div>
            <div class="col-md-9">
                {{Form::email('email', '', array('class'=>'form-control', 'placeholder' => '.email'))}}
                @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('password', '.heslo') }}
            </div>
            <div class="col-md-9">
                {{ Form::password('password', array('class'=>'form-control', 'placeholder' => '.heslo')) }}
                @if ($errors->has('password')) <p class="help-block" style="margin-bottom: 0px;">{{ $errors->first('password') }}</p> @endif
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('remember', '.zapamätať prihlásenie', array('class'=>'col-md-3')) }}
            <div class="col-md-3">
                {{ Form::checkbox('remember', 'true', array('class'=>'form-control')) }}
            </div>
            <div class="col-md-6 text-right">
                {{ HTML::linkAction('RemindersController@getRemind', '.zabudol som heslo') }}
            </div>
        </div>
        {{Form::submit('.prihlás', array('class'=>'btn btn-default'))}}
    </div>
    {{ Form::close() }}
</div>
@stop