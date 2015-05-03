@extends('layouts.center_content')

@section('style')
    button{
        margin-right: 5px;
    }
@stop

@section('ready_js')
    function compare(a,b) {
        if (a.name < b.name){
           return -1;
        }
        if (a.name > b.name){
          return 1;
        }
        return 0;
    }

    var getUsers = function(){
        $.ajax({
            'url': "{{ action('SubjectController@getUsers') }}",
            'method': 'post',
            'dataType': 'json',
            'success': function(data){
                console.log(data);
                $('tbody').empty();
                data.sort(compare);
                data.forEach(function(val){
                    var buttons = $('<td />');
                    var block_button = $('<button />').attr({
                        'class': 'btn ' + ((val.state == {{Participant::BLOCKED}}) ? 'btn-danger' : 'btn-default')
                    }).on('click', function(){
                        updateUser({
                            'state':{{Participant::BLOCKED}},
                            'user_id': val.id
                        });
                    }).append($('<span />').attr({
                        'class': 'glyphicon glyphicon-remove',
                        'aria-hidden': 'true'
                    }));
                    var accepted_button = $('<button />').attr({
                        'class': 'btn ' + ((val.state == {{Participant::ACCEPTED}}) ? 'btn-success' : 'btn-default')
                    }).on('click', function(){
                        updateUser({
                            'state':{{Participant::ACCEPTED}},
                            'user_id': val.id
                        });
                    }).append($('<span />').attr({
                        'class': 'glyphicon glyphicon-ok',
                        'aria-hidden': 'true'
                    }));
                    buttons.append(accepted_button);
                    buttons.append(block_button);
                    $('tbody').append(
                        $('<tr />').append(
                            $('<td />').text(val.name)
                        ).append(
                            buttons
                        )
                    );
                });
            }
        });
    }
    
    var updateUser = function(param){
        $.ajax({
            'url': "{{ action('SubjectController@updateUser') }}",
            'method': 'post',
            'data': param,
            'success': function(){
                getUsers();
            }
        })
    }
    getUsers();
@stop

@section('center')
<div class="col-md-12">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Meno</th>
                <th>Stav</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@stop