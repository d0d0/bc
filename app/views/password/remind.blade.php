@extends('layouts.center_content')

@section('center')
<div class="col-md-6 col-md-offset-3">
    {{ Form::open(array('action' => 'RemindersController@postRemind', 'class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')) }}
    <div class="form-group thumbnail">
        <div class="form-group">
            <div class="col-md-3">
                {{ Form::label('email', Lang::get('common.email')) }}
            </div>
            <div class="col-md-9">
                {{Form::email('email', '',array('class'=>'form-control', 'placeholder' => Lang::get('common.enter_email')))}}
            </div>
        </div>
        {{Form::submit(Lang::get('common.send'),array('class'=>'btn btn-default'))}}
    </div>
    {{ Form::close() }}
</div>
@stop