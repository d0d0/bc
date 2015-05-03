@extends('layouts.center_content')

@section('style')
    .join{
        cursor: pointer;
    }
@stop

@section('ready_js')
    var joinSubject = function(param){
        $.ajax({
            'url': "{{ action('SubjectController@joinSubject') }}",
            'method': 'post',
            'data': param,
            'success': function(){
                getSubjects();
            }
        });
    };

    var getSubjects = function(){
        $.ajax({
            'url': "{{ action('SubjectController@getSubjects') }}",
            'method': 'post',
            'dataType': 'json',
            'success': function(data){
                $('tbody').empty();
                data.forEach(function(val){
                    if(val.state){
                        state = val.state;
                    }else{
                        state = $('<a />').attr({
                            'class': 'join'
                        }).text('Prihlás na predmet').on('click', function(){
                            joinSubject({
                                'subject_id': val.id
                            });
                            return false;
                        });
                    }
                    $('tbody').append($('<tr />').append(
                        $('<td />').text(val.name)
                    ).append(
                        $('<td />').append(
                            state
                        )
                    ));
                });
            }
        });
    }
    
    getSubjects();
@stop

@section('center')
<div class="col-md-12">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Názov predmetu</th>
                <th>Stav</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@stop