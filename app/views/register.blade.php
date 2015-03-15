@extends('layouts.center_content')

@section('center')
<div class="col-md-6 col-md-offset-3" style="margin-top: 5em">
    {{ Form::open(array('action' => 'RegistrationController@postRegister', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}
    <div class="form-group thumbnail">
        <div class="form-group {{ $errors->has('name') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('name', Lang::get('Meno')) }}
            </div>
            <div class="col-md-9">
                {{Form::text('name', '', array('class'=>'form-control', 'placeholder' => Lang::get('Meno')))}}
                @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('surname') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('surname', Lang::get('Priezvisko')) }}
            </div>
            <div class="col-md-9">
                {{Form::text('surname', '', array('class'=>'form-control', 'placeholder' => Lang::get('Priezvisko')))}}
                @if ($errors->has('surname')) <p class="help-block">{{ $errors->first('surname') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('email', Lang::get('Email')) }}
            </div>
            <div class="col-md-9">
                {{Form::email('email', '', array('class'=>'form-control', 'placeholder' => Lang::get('Email')))}}
                @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('password', Lang::get('Heslo')) }}
            </div>
            <div class="col-md-9">
                {{ Form::password('password', array('class'=>'form-control', 'placeholder' => Lang::get('Heslo'))) }}
                @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password_confirmation') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('password_confirmation', Lang::get('Potvrdenie hesla')) }}
            </div>
            <div class="col-md-9">
                {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder' => Lang::get('Potvrdenie hesla'))) }}
                @if ($errors->has('password_confirmation')) <p class="help-block" style="margin-bottom: 0px;">{{ $errors->first('password_confirmation') }}</p> @endif
            </div>
        </div>
        {{Form::submit(Lang::get('Registruj'), array('class'=>'btn btn-default'))}}
    </div>
    {{ Form::close() }}
</div>
@stop