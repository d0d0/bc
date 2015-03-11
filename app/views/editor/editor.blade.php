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

//TODO: group id
var docName = null;
@foreach($files as $file)
    addEditor('{{{ $file->node_id }}}', '{{{ $file->name }}}');
@endforeach

docName = '{{{ $task->id . 1 }}}';

sharejs.open("toggle:" + docName, 'text', 'http://46.229.238.230:8000/channel', function (error, doc) {
    var toggleEditor = function () {
        var result;
        editors.forEach(function(editor){
            editor.setReadOnly(!editor.getReadOnly());
            if (editor.getReadOnly()) {
                $(editor.container).append($('<div />').css({
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
        });
        return result;
    };       

    $('#test').on('click', function(e) {
        e.preventDefault();
        var l = Ladda.create(this);
        l.start();
        var data = { 'task_id': {{{ $task->id }}}, 'group_id': 1, 'files': [] };
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
        var dt = $('<dt />').text(msg.name);
        var dd = $('<dd />').text(msg.text);
        $('#shouts').append(dt).append(dd);
    }

    function shoutOut(value) {
        var s;
        if (value) {
            s = value;
        } else if ($.trim($('#input').val())) {
            s = $.trim($('#input').val());
        } else {
            return false;
        }
        $('#input').val('');
        var msg = {
            'name': '{{ Auth::user()->name }}',
            'text': s
        };
        doc.shout(msg);
        if (!value) {
            addShout(msg);
        }
    }

    $('#shout').on('click', function () {
        shoutOut();
    });

    $('#input').keyup(function (e) {
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
<div>
    <input type="button" id="toggle" value="Toggle">
    <button class="btn btn-primary ladda-button" id="test" data-style="zoom-in">
        <span class="ladda-label">{{ Lang::get('Otestuj') }}</span>
    </button>
</div>
<div>
    <input type="text" id="input" placeholder="Shout something&hellip;"/>
    <input type="button" id="shout" value="shout"/>
    <dl id="shouts" class="dl-horizontal"></dl>
</div>
<div id="result"></div>
@stop