@extends('layouts.master')

@section('js')
    {{ HTML::script('js/ace/ace.js') }}
    {{ HTML::script('js/ace/ext-language_tools.js') }}
    {{ HTML::script('js/ace/ext-themelist.js') }}
    {{ HTML::script('js/bcsocket-uncompressed.js') }}
    {{ HTML::script('js/share.uncompressed.js') }}
    {{ HTML::script('js/ace_c.js') }}
    {{ HTML::script('js/spin.min.js') }}
    {{ HTML::script('js/ladda.min.js') }}
    {{ HTML::style('css/ladda-themeless.min.css') }}
@stop

@section('style')
#chat .chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}

#chat .chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

#chat .chat li .chat-body p
{
    margin: 0;
    color: #777777;
}

#chat .panel .slidedown .glyphicon,#chat  .chat .glyphicon
{
    margin-right: 5px;
}

#chat .panel-body
{
    overflow-y: scroll;
    height: 250px;
}

.glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
}

@-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
}

@keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
}

dd{
    word-wrap: break-word;
}

.panel-heading a:after {
    font-family:'Glyphicons Halflings';
    content:"\e114";
    float: right;
    color: grey;
}

.collapsed > a:after {
    -webkit-transform: rotate(-90deg); 
    -moz-transform: rotate(-90deg); 
    -ms-transform: rotate(-90deg); 
    -o-transform: rotate(90deg); 
    transform: rotate(-90deg);
}
@stop

@section('ready_js')
var editors = { };
var docs = { };
var themelist = ace.require("ace/ext/themelist")
var themes = themelist.themesByName;

var onChangeTab = function(e){
    var id = $(e.target).attr('aria-controls');
    editors[id].focus();
    editors[id].navigateFileEnd();
};

var addEditor = function(node_id, name){
    editors[node_id] = ace.edit('editor' + node_id);
    editors[node_id]['name'] = name;
    editors[node_id].setOptions({
        enableBasicAutocompletion: true
    });

    editors[node_id].setTheme("ace/theme/merbivore");
    editors[node_id].getSession().setMode("ace/mode/c_cpp");
    editors[node_id].$blockScrolling = Infinity;

    sharejs.open("code:" + node_id, 'text', 'http://46.229.238.230:8000/channel', function (error, doc) {
        docs[node_id] = doc;
        docs[node_id].attach_ace(editors[node_id]);
        @if($new)
            $.ajax({
                url: '{{ URL::action('SolutionController@getText') }}',
                method: 'post',
                dataType: 'json',
                data: {
                    'node_id': node_id
                },
                success: function(data){
                    editors[node_id].setValue(data[0]['text'], 1);
                }
            });
        @endif
    });
};

@foreach($files as $file)
    addEditor('{{{ $file->node_id }}}', '{{{ $file->name }}}');
@endforeach

var docName = '{{{ $task->id . $group_id }}}';

sharejs.open("toggle:" + docName, 'text', 'http://46.229.238.230:8000/channel', function (error, doc) {
    var toggleEditor = function () {
        var result;
        for (var key in editors) {
            editors[key].setReadOnly(!editors[key].getReadOnly());
            if (editors[key].getReadOnly()) {
                $(editors[key].container).append($('<div />').css({
                    'position': 'absolute',
                    'top': 0,
                    'bottom': 0,
                    'left': 0,
                    'right': 0,
                    'background': 'rgba(150,150,150,0.5)',
                    'z-index': 100
                }).attr('id', 'cover'));
                result =  true;
            } else {
                $('#cover').remove();
                result = false;
            }
        }
        return result;
    };       

    $('#test').on('click', function(e) {
        e.preventDefault();
        var l = Ladda.create(this);
        l.start();
        var data = { 'task_id': {{{ $task->id }}}, 'group_id': {{ $group_id }}, 'files': [] };
        for (var key in editors) {
            var val = editors[key];
            data['files'].push({ 'text': val.getSession().getValue()+'', 'name': val.name+'' });
        };
        $('#result').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
        doc.shout({'msg': 'start'});
        toggleEditor();
        $.ajax({
            'url': '{{ URL::action('SolutionController@add') }}',
            'method': 'post',
            'dataType': 'text',
            'data': data,
            'success': function(result){
                $('#result').html(result);
                toggleEditor();
                doc.shout({'msg': 'loaded', 'result': result});
            }
        }).always(function(){
            l.stop();
        });
    });

    doc.on('shout', function (msg) {
        if(msg.msg == 'start'){
            toggleEditor();
            var l = Ladda.create(document.getElementById('test'));
            l.start();
            $('#result').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
        }
        if(msg.msg && msg.msg == 'loaded'){
            toggleEditor();
            var l = Ladda.create(document.getElementById('test'));
            $('#result').html(msg.result)
            l.stop();
        }
    });
});

sharejs.open("shout:" + docName, 'text', 'http://46.229.238.230:8000/channel', function (error, doc) {
    function addShout(msg) {        
        $('.chat').append('<li class="clearfix">' +
                            '<div class="chat-body clearfix">' +
                                '<div class="header">' +
                                    '<strong class="primary-font">' + msg.name + '</strong>' +
                                '</div>' +
                                '<p>' + msg.text + '</p>' +
                            '</div>' +
                        '</li>'
        );
        if(!$('#chat .panel-body').is(':visible')){
            $('#chat .panel-heading').css({
                'background-color': '#d9534f'
            });
            $('#chat .panel-primary').css({
                'border-color': '#d43f3a'
            });
        }else{
            $('#chat .panel-heading').css({
                'background-color': '#337ab7'
            });
            $('#chat .panel-primary').css({
                'border-color': '#337ab7'
            });
        }
        var objDiv = document.getElementById('chat_panel');
        objDiv.scrollTop = objDiv.scrollHeight;
    }

    function shoutOut(value) {
        var s;
        if (value) {
            s = value;
        } else if ($.trim($('#btn-input').val())) {
            s = $.trim($('#btn-input').val());
        } else {
            return false;
        }
        $('#btn-input').val('');
        var msg = {
            'name': '{{ Auth::user()->name }}',
            'text': s
        };
        doc.shout(msg);
        if (!value) {
            addShout(msg);
        }
    }

    $('#btn-input').keyup(function (e) {
        if (e.keyCode == 13) {
            shoutOut();
        }
    });

    doc.on('shout', function (msg) {
        addShout(msg);
    });

    $(window).on('beforeunload', function () {
        shoutOut('sa odpojil');
    });

    shoutOut('sa pripojil');
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    onChangeTab(e);
});

sharejs.open("tests:" + docName, 'text', 'http://46.229.238.230:8000/channel', function (error, doc) {
    $('#add').on('click', function(){
        $('#addTest').modal('show');
    });

    $('#addTestButton').on('click', function(){
        if($('#testfunction').val() && $('#expected').val() != ''){
            $.ajax({
                'url': '{{ URL::action('SolutionController@addOwnTest') }}',
                'method': 'post',
                'dataType': 'json',
                'data': {
                    'task_id' : {{ $task->id }},
                    'group_id' : {{ $group_id }},
                    'codebefore' : $('#codebefore').val(),
                    'testfunction' : $('#testfunction').val(),
                    'compare' : $('#compare').val(),
                    'expected' : $('#expected').val(),
                    'codeafter' : $('#codeafter').val(),
                },
                'success': function(result){
                    if(result['result']){
                        doc.shout({'msg': 'reload'});
                        reload();
                        $('#addTest').modal('hide');
                    }
                }
            });
        }
    });
    
    var deleteTest = function(id){
        $.ajax({
            'url': '{{ URL::action('SolutionController@deleteOwnTest') }}',
            'method': 'post',
            'dataType': 'json',
            'data': {
                'id' : id
            },
            'success': function(result){
                reload();
                doc.shout({'msg': 'reload'});
            }
        });
    };
    
    var reload = function(){
        $.ajax({
            'url': '{{ URL::action('SolutionController@getOwnTest') }}',
            'method': 'post',
            'dataType': 'json',
            'data': {
                'task_id' : {{ $task->id }},
                'group_id' : {{ $group_id }}
            },
            'success': function(result){
                $('#owntests tbody').empty();
                result.forEach(function(val){
                    $('#owntests tbody').append($('<tr />').append($('<td />').text(val['codebefore']))
                        .append($('<td />').text(val['testfunction']))
                        .append($('<td />').text(function(){
                            switch(val['compare']){
                                case "{{ Test::EQUAL }}":
                                    return '==';
                                case "{{ Test::NON_EQUAL }}":
                                    return '!=';
                            };
                        }))
                        .append($('<td />').text(val['expected']))
                        .append($('<td />').text(val['codeafter']))
                        .append($('<td />').html(function(){
                            var delete_button = $('<button />').on('click', function(){
                                $(this).attr({
                                    'disabled': 'disabled'
                                });
                                deleteTest(val['id']);
                            }).attr({
                                'class': 'btn btn-danger btn-sm',
                                'type': 'button'
                             }).append($('<span />').attr({
                                'class': 'glyphicon glyphicon-remove',
                                'aria-hidden': 'true'
                             }));
                            return delete_button
                        }))
                    );
                });
            }
        });
    };
    
    doc.on('shout', function (msg) {
        if(msg.msg == 'reload'){
            reload();
        }
    });
    reload();
});

$('#chat .panel-heading').on('click', function(){
    $('#chat .panel-body, #chat .panel-footer').toggle();
    $('#chat .panel-heading').css({
        'background-color': '#337ab7'
    });
    $('#chat .panel-primary').css({
        'border-color': '#337ab7'
    });
});

$('#chat .panel-body, #chat .panel-footer').on('click', function(){
    $('#btn-input').focus();
});
@stop

@section('content')
<div class="panel panel-default noselect">
    <div class="panel-heading" data-toggle="collapse" data-target="#collapseOne">
        <a href="javascript:void(0);">{{ $task->name }}</a>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
            {{ $task->text }}
        </div>
    </div>
</div>
{{ Form::hidden('id', $id) }}
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Editor</h3>
    </div>
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <?php $i = 0; ?>
            @foreach($files as $file)
            <li role="presentation" {{ $i++ == 0 ? 'class="active"' : '' }}>
                <a href="#{{{ $file->node_id }}}" aria-controls="{{{ $file->node_id }}}" role="tab" data-toggle="tab">
                    {{{ $file->name }}}
                </a>
            </li>
            @endforeach
            <li class="pull-right" style="margin-right: 15px; margin-top: 4px">
                <div>
                    <button class="btn btn-primary ladda-button" id="test" data-style="zoom-in">
                        <span class="ladda-label">{{ Lang::get('Otestuj') }}</span>
                    </button>
                </div>
            </li>
        </ul>
        <div class="tab-content">
            <?php $i = 0; ?>
            @foreach($files as $file)
            <div role="tabpanel" class="tab-pane {{ $i++ == 0 ? 'active' : '' }}" id="{{{ $file->node_id }}}">
                <div class="panel-body">
                    <div class="editor" id="editor{{{ $file->node_id }}}"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="panel panel-default noselect" style="margin-bottom: 50px;">
    <div class="panel-heading">
        <h3 class="panel-title">Vlastné testy</h3>
    </div>
    <div class="panel-body">
        <table id="owntests" class="table table-striped">
            <thead>
                <tr>
                    <th>Kód pred</th>
                    <th>Testovaná funkcia</th>
                    <th>Porovnanie</th>
                    <th>Očakávaná hodnota</th>
                    <th>Kód po</th>
                    <th>
                        <button type="button" class="btn btn-success btn-sm" id="add">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<div id="result" style="margin-bottom: 50px;"></div>
<div class="modal fade" id="addTest" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pridanie testu</h4>
            </div>
            <div class="modal-body" id="addTestBody">
                <form role="form">
                    <div class="form-group">
                        <label for="codebefore" class="control-label">{{ Lang::get('Kód pred') }}:</label>
                        <input type="text" class="form-control" id="codebefore">
                        <label for="testfunction" class="control-label">{{ Lang::get('Testovacia funkcia') }}:</label>
                        <input type="text" class="form-control" id="testfunction">
                        <label for="compare" class="control-label">{{ Lang::get('Porovnanie') }}:</label>
                        <select class="form-control" id="compare">
                            <option value="{{ Test::EQUAL }}">==</option>
                            <option value="{{ Test::NON_EQUAL }}">!=</option>
                        </select>
                        <label for="expected" class="control-label">{{ Lang::get('Očakávaná hodnota') }}:</label>
                        <input type="text" class="form-control" id="expected">
                        <label for="codeafter" class="control-label">{{ Lang::get('Kód po') }}:</label>
                        <input type="text" class="form-control" id="codeafter">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary" id="addTestButton">Pridaj test</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('last')
<div id="chat" class="container" style="position: fixed; bottom: 0; right: 0; z-index: 999">
    <div class="row">
        <div class="col-md-3 col-md-offset-9">
            <div class="panel panel-primary" style="margin: 0">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Chat
                </div>
                <div class="panel-body" style="display: none; margin-right: 1px" id="chat_panel">
                    <ul class="chat"></ul>
                </div>
                <div class="panel-footer" style="display: none">
                    <input id="btn-input" type="text" class="form-control input-sm">
                </div>
            </div>
        </div>
    </div>
</div>
@stop