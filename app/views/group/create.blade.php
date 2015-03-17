@extends('layouts.center_content')

@section('style')
{{ HTML::script('js/spin.min.js') }}
{{ HTML::script('js/ladda.min.js') }}
{{ HTML::style('css/ladda-themeless.min.css') }}
@stop

@section('ready_js')
    var reload = function(id){
        $.ajax({
            url: '{{ URL::action('GroupController@groups') }}',
            method: 'post',
            dataType: 'json',
            data: {
                'id': id 
            },
            success: function(answer){
                console.log(answer);
            },
            error: function(){
            }
            }).always(function(){
            
        });
    }
    
    $('#save').on('click', function(){
        reload($('#task_id').val());
        return false;
    });
@stop

@section('center')
<div class="col-md-6 col-md-offset-3">
    <form class="form-horizontal clearfix" role="form">
        <div class="form-group thumbnail">
            <div class="form-group">
                <label for="name" class="col-md-1 control-label">{{ Lang::get('Meno skupiny') }}</label>
                <div class="col-md-11">
                    <input type="text" id="name" placeholder="{{ Lang::get('Meno skupiny') }}" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-md-1 control-label">{{ Lang::get('Zadanie') }}</label>
                <div class="col-md-11">
                    <select class="form-control" id="task_id">
                        @if(Auth::user()->lastSubject)
                            @foreach($tasks as $task)
                                <option value="{{ $task->id }}" @if($task->id == $id) selected @endif>{{{ $task->name }}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-1 col-md-offset-10">
                    <button class="btn btn-primary ladda-button" id="save" data-style="zoom-in" @if(!Auth::user()->lastSubject) disabled @endif>
                        <span class="ladda-label">{{ Lang::get('Ulož') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@stop