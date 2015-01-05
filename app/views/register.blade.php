@extends('layouts.center_content')

@section('center')
<div class="col-md-6 col-md-offset-3">
    {{ Form::open(array('action' => 'RegistrationController@postRegister', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}
    <div class="form-group thumbnail">
        <div class="form-group {{ $errors->has('name') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('name', Lang::get('common.name')) }}
            </div>
            <div class="col-md-9">
                {{Form::text('name', '', array('class'=>'form-control', 'placeholder' => Lang::get('common.enter_name')))}}
                @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('surname') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('surname', Lang::get('common.surname')) }}
            </div>
            <div class="col-md-9">
                {{Form::text('surname', '', array('class'=>'form-control', 'placeholder' => Lang::get('common.enter_surname')))}}
                @if ($errors->has('surname')) <p class="help-block">{{ $errors->first('surname') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('phone') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('phone', Lang::get('common.phone')) }}
            </div>
            <div class="col-md-9">
                {{Form::text('phone', '', array('class'=>'form-control', 'placeholder' => Lang::get('common.enter_phone')))}}
                @if ($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('address') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('address', Lang::get('common.address')) }}
            </div>
            <div class="col-md-9">
                {{Form::text('address', '', array('class'=>'form-control', 'placeholder' => Lang::get('common.enter_address')))}}
                @if ($errors->has('surname')) <p class="help-block">{{ $errors->first('address') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('email', Lang::get('common.email')) }}
            </div>
            <div class="col-md-9">
                {{Form::email('email', '', array('class'=>'form-control', 'placeholder' => Lang::get('common.enter_email')))}}
                @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('password', Lang::get('common.password')) }}
            </div>
            <div class="col-md-9">
                {{ Form::password('password', array('class'=>'form-control', 'placeholder' => Lang::get('common.enter_password'))) }}
                @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password_confirmation') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('password_confirmation', Lang::get('common.confirm_password')) }}
            </div>
            <div class="col-md-9">
                {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder' => Lang::get('common.again_password'))) }}
                @if ($errors->has('password_confirmation')) <p class="help-block" style="margin-bottom: 0px;">{{ $errors->first('password_confirmation') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('division') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('division', Lang::get('common.division')) }}
            </div>
            <div class="col-md-9">
                {{ Form::select('division', array(User::BO => 'BO', User::MO => 'MO', User::PARA => 'Para'), null, array('class' => 'form-control')) }}
                @if ($errors->has('division')) <p class="help-block" style="margin-bottom: 0px;">{{ $errors->first('rank') }}</p> @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('rank') ? "has-error" : "" }}">
            <div class="col-md-3">
                {{ Form::label('rank', Lang::get('common.division')) }}
            </div>
            <div class="col-md-9">
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="rank" value="{{ User::MEMBER }}" checked="true"> .Member
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="rank" value="{{ User::SCHOOL }}"> .School
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="rank" value="{{ User::EXPECTANT }}"> .Expectant
                    </label>
                </div>
                @if ($errors->has('division')) <p class="help-block" style="margin-bottom: 0px;">{{ $errors->first('division') }}</p> @endif
            </div>
        </div>
        {{Form::submit(Lang::get('common.send'), array('class'=>'btn btn-default'))}}
    </div>
    {{ Form::close() }}
</div>
@stop