@extends('layouts.master')

@section('js')
{{ HTML::script('js/ace/ace.js') }}
{{ HTML::script('js/ace/ext-language_tools.js') }}
{{ HTML::script('js/ace/ext-themelist.js') }}
{{ HTML::script('js/bcsocket-uncompressed.js') }}
{{ HTML::script('js/share.uncompressed.js') }}
{{ HTML::script('js/ace_c.js') }}
@stop

@section('style')
.editor{
    height: 300px;
}

dd{
    word-wrap: break-word;
}

.noselect {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
@stop

@section('ready_js')

var editors = { };
var docs = { };
var themelist = ace.require("ace/ext/themelist")
var themes = themelist.themesByName;

var addEditor = function(node_id){
    editors[node_id] = ace.edit('editor' + node_id);
    
    editors[node_id].setOptions({
        enableBasicAutocompletion: true
    });

    editors[node_id].setTheme("ace/theme/merbivore");
    editors[node_id].getSession().setMode("ace/mode/c_cpp");
    editors[node_id].$blockScrolling = Infinity;

    sharejs.open("code:" + node_id, 'text', 'http://62.169.176.249:8000/channel', function (error, doc) {
        docs[node_id] = doc;
        docs[node_id].attach_ace(editors[node_id]);
    });
    
    sharejs.open("toggle:" + node_id, 'text', 'http://62.169.176.249:8000/channel', function (error, doc) {
        var toggleEditor = function () {
            editors[node_id].setReadOnly(!editors[node_id].getReadOnly());
            if (editors[node_id].getReadOnly()) {
                $(editors[node_id].container).append($('<div />').css({
                    'position': 'absolute',
                    'top': 0,
                    'bottom': 0,
                    'left': 0,
                    'right': 0,
                    'background': 'rgba(150,150,150,0.5)',
                    'z-index': 100
                }).attr('id', 'cover'));
                return true;
            } else {
                $('#cover').remove();
                return false;
            }
        };

        $('#toggle').on('click', function () {
            doc.shout(toggleEditor() ? 'true' : 'false');
        });

        doc.on('shout', function () {
            toggleEditor();
        });
    });
};

var deleteEditor = function(node_id){
    $.ajax({
        method: 'post',
        url: '{{ URL::action('SolutionController@deleteFile') }}',
        dataType: 'json',
        data: {
            'node_id': node_id
        },
        url: '{{ URL::action('SolutionController@deleteFile') }}',
        success: function(answer){
            docs[node_id].close();
            console.log($('a[aria-controls=' + node_id + ']').attr('class'));
            if($('a[aria-controls=' + node_id + ']').parent().attr('class')){
                $('li[role=presentation]:first-of-type').attr('class', 'active');
                $('div[role=tabpanel]:first-of-type').attr('class', 'tab-pane active');
            }
            $('#' + node_id).remove();
            $('a[aria-controls=' + node_id + ']').parent().remove();
        }
    });
}

$('#showDeleted').on('click', function(){
    $('#deletedFilesBody').load('{{ URL::action('SolutionController@deletedFiles')}}', { 'id': '{{ $id }}' }, function(){
        $('#deletedFiles').modal('show');
    });
});

$('#showAddFile').on('click', function(){
    $('#addFile').modal('show');
});

$('#addFileButton').on('click', function(){
    $.ajax({
        method: 'post',
        url: '{{ URL::action('SolutionController@addFile')}}',
        dataType : 'json',
        data : {
            'id': $('input[name=id]').val(),
            'name': $('#filename').val(),
            'include_header': $('#includeHeader').is(':checked')
        },
        success: function(answer){
            console.log(answer);
            if(answer['node_id']){
                $('#addFile').modal('hide');
                appendFile(answer);
            }
        }
    });
});

var appendFile = function(param){
    $('li[role=presentation]').removeClass('active');
    var li = $('<li />').attr({
        'role': 'presentation',
        'class': 'active'
    }).append($('<a />').attr({
        'href': '#' + param['node_id'],
        'aria-controls': param['node_id'],
        'role': 'tab',
        'data-toggle': 'tab',
    }).text(param['name']).on('shown.bs.tab', function (e) {
        e.target;
        e.relatedTarget;
        console.log('ahoj');
      }).append($('<span />').attr({
        'class': 'glyphicon glyphicon-remove text-danger',
        'aria-hidden': 'true'
    }).on('click', function(e){
        e.stopPropagation();
        var node_id = $(this).parent().attr('aria-controls');
        deleteEditor(node_id);
    })));
    $(li).insertBefore('#showAddFile');
    
    $('div[role=tabpanel]').removeClass('active');
    var div = $('<div />').attr({
        'role': 'tabpanel',
        'class': 'tab-pane active',
        'id': param['node_id']
    }).append($('<div />').attr({
        'class': 'panel-body'
    }).append($('<div />').attr({
        'class': 'editor',
        'id': 'editor'+param['node_id']
    })));
    $('.tab-content').append(div);
    
    addEditor(param['node_id']);
};

$('.glyphicon-remove').on('click', function(e){
    e.stopPropagation();
    var node_id = $(this).parent().attr('aria-controls');
    deleteEditor(node_id);
});

var docName = null;
@foreach($files as $file)
    addEditor('{{{ $file->node_id }}}');
@endforeach

sharejs.open("shout:" + docName, 'text', 'http://62.169.176.249:8000/channel', function (error, doc) {
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
  e.target // newly activated tab
  e.relatedTarget // previous active tab
  console.log('ahoj');
})
@stop

@section('content')
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
                    @if($file->name != 'main.cpp')
                        <span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>
                    @endif
                </a>
            </li>
            @endforeach
            <li role="presentation" class="noselect" id="showAddFile">
                <a>
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </li>
            <li role="presentation" class="pull-right" id="showDeleted">
                <a href="javascript:void(0)">
                    .Obnoviť súbory
                </a>
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
<div>
    <input type="button" id="toggle" value="Toggle">
</div>
<div>
    <input type="text" id="input" placeholder="Shout something&hellip;"/>
    <input type="button" id="shout" value="shout"/>
    <dl id="shouts" class="dl-horizontal"></dl>
</div>
<div class="modal fade" id="deletedFiles" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">.Súbory na obnovenie</h4>
            </div>
            <div class="modal-body" id="deletedFilesBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="deletedFilesButton">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addFile" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">.Pridanie súboru</h4>
            </div>
            <div class="modal-body" id="addFileBody">
                <form role="form">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">{{ Lang::get('article.filename') }}:</label>
                        <input type="text" class="form-control" id="filename">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="includeHeader"> .include header
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addFileButton">Save changes</button>
            </div>
        </div>
    </div>
</div>
@stop