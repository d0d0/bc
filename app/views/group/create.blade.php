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
            var table = $('.table tbody');
            table.empty();
            answer.groups.forEach(function(val){
                console.log(val.can_edit);
                if(val.can_edit){
                    var buttons = [];
                    buttons[0] = $('<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>').on('click', function(){
                        delete_group(val.id);
                    });
                    buttons[1] = $(' <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>').on('click', function(){
                        approve(val.id);
                    });
                }else if(!answer.allow_join){
                    if(val.is_member){
                        var buttons = $('<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></button>').on('click', function(){
                            leave_group(val.id);
                        });
                    }else if(!answer.is_member){
                        var buttons = $('<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>').on('click', function(){
                            join_group(val.id);
                        });
                    }
                };
                table.append($('<tr />').append(
                        $('<td />').text(val.name)
                    ).append(
                        $('<td />').text(val.members.join(', '))
                    ).append(
                        $('<td />').append(buttons)
                    )
                );
            });
        },
        error: function(){
        
        }
    }).always(function(){

    });
}

var save = function(){
    $.ajax({
        url: '{{ URL::action('GroupController@createGroup') }}',
        method: 'post',
        dataType: 'json',
        data: {
            'task_id': $('#task_id').val(),
            'name': $('#name').val()
        },
        success: function(answer){
            reload($('#task_id').val());
        },
        error: function(){
        
        }
    }).always(function(){

    });
};

var approve = function(id){
    $.ajax({
        url: '{{ URL::action('GroupController@approve') }}',
        method: 'post',
        dataType: 'json',
        data: {
            'id': id
        },
        success: function(answer){
            reload($('#task_id').val());
        },
        error: function(){
        
        }
    }).always(function(){

    });
};

var delete_group = function(id){
    $.ajax({
        url: '{{ URL::action('GroupController@delete') }}',
        method: 'post',
        dataType: 'json',
        data: {
            'id': id
        },
        success: function(answer){
            reload($('#task_id').val());
        },
        error: function(){
        
        }
    }).always(function(){

    });
};

var join_group = function(id){
    $.ajax({
        url: '{{ URL::action('GroupController@join') }}',
        method: 'post',
        dataType: 'json',
        data: {
            'id': id
        },
        success: function(answer){
            reload($('#task_id').val());
        },
        error: function(){
        
        }
    }).always(function(){

    });
};

var leave_group = function(id){
    $.ajax({
        url: '{{ URL::action('GroupController@leave') }}',
        method: 'post',
        dataType: 'json',
        data: {
            'id': id
        },
        success: function(answer){
            reload($('#task_id').val());
        },
        error: function(){
        
        }
    }).always(function(){

    });
};

$('#task_id').on('change', function(){
    reload($(this).val());
});

$('#save').on('click', function(){
    save();
    return false;
});

$('#reload').on('click', function(){
    reload($('#task_id').val());
});

reload($('#task_id').val());
@stop

@section('center')
<div class="col-md-6 col-md-offset-3">
    <form class="form-horizontal clearfix" role="form">
        <div class="form-group thumbnail">
            <div class="form-group">
                <label for="name" class="col-md-2 control-label">{{ Lang::get('Meno skupiny') }}</label>
                <div class="col-md-10">
                    <input type="text" id="name" placeholder="{{ Lang::get('Meno skupiny') }}" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-md-2 control-label">{{ Lang::get('Zadanie') }}</label>
                <div class="col-md-10">
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
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>
                Názov skupiny
            </th>
            <th>
                Členovia
            </th>
            <th>
                <button type="button" class="btn btn-success" id="reload">
                    <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
@stop