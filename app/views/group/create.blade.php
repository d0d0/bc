@extends('layouts.center_content')

@section('style')
    {{ HTML::script('js/spin.min.js') }}
    {{ HTML::script('js/ladda.min.js') }}
    {{ HTML::style('css/ladda-themeless.min.css') }}
@stop

@section('js')
    {{ HTML::script('js/bcsocket-uncompressed.js') }}
    {{ HTML::script('js/share.uncompressed.js') }}
@stop

@section('ready_js')

sharejs.open("groups", 'text', 'http://46.229.238.230:8000/channel', function (error, doc) {
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
                    if(!val.approved){
                        if(val.can_edit){
                            var buttons = [];
                            buttons[0] = $('<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>').on('click', function(){
                                delete_group(val.id);
                            });
                            buttons[1] = $('<span />').html('&nbsp;');
                            buttons[2] = $('<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>').on('click', function(){
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
                        }
                    }
                    table.append($('<tr />').append(
                            $('<td />').text(val.name)
                        ).append(
                            $('<td />').text(val.members.join(', '))
                        ).append(
                            $('<td />').append(buttons)
                        )
                    );
                });
            }
        });
    };

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
                doc.shout({'msg': 'reload', 'task_id': $('#task_id').val()});
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
                doc.shout({'msg': 'reload', 'task_id': $('#task_id').val()});
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
                doc.shout({'msg': 'reload', 'task_id': $('#task_id').val()});
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
                doc.shout({'msg': 'reload', 'task_id': $('#task_id').val()});
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
                doc.shout({'msg': 'reload', 'task_id': $('#task_id').val()});
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
        doc.shout({'msg': 'reload', 'task_id': $('#task_id').val()});
        save();
        return false;
    });
    
    doc.on('shout', function(msg){
        if(msg.msg == 'reload' && msg.task_id == $('#task_id').val()){
            reload($('#task_id').val());
        }
    });

    reload($('#task_id').val());
});
@stop

@section('center')
<div>
    <form class="form-inline clearfix thumbnail text-center col-md-6 col-md-offset-3">
        <div class="form-group">
            <label for="name">Názov skupiny</label>
            <input type="text" id="name" placeholder="{{ Lang::get('Názov skupiny') }}" class="form-control" value="">
        </div>
        <div class="form-group">
            <label for="task_id">Zadanie</label>
            <select class="form-control" id="task_id">
                @if(Auth::user()->lastSubject)
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}" @if($task->id == $id) selected @endif>{{{ $task->name }}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <button class="btn btn-primary ladda-button" id="save" data-style="zoom-in" @if(!Auth::user()->lastSubject) disabled @endif>
            <span class="ladda-label">{{ Lang::get('Vytvor skupinu') }}</span>
        </button>
      </form>
</div>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th style="width: 30%">
                Názov skupiny
            </th>
            <th style="width: 60%">
                Členovia
            </th>
            <th style="width: 10%">
                
            </th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
@stop