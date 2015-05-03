@extends('layouts.center_content')

@section('js')
{{ HTML::style('css/font-awesome.min.css') }}
{{ HTML::style('css/summernote.css') }}
{{ HTML::script('js/summernote.min.js') }}
{{ HTML::script('js/ace/ace.js') }}
{{ HTML::script('js/ace/ext-language_tools.js') }}
{{ HTML::style('css/datepicker.min.css') }}
{{ HTML::script('js/moment.min.js') }}
{{ HTML::script('js/datepicker.min.js') }}
{{ HTML::script('js/spin.min.js') }}
{{ HTML::script('js/ladda.min.js') }}
{{ HTML::style('css/ladda-themeless.min.css') }}
@stop

@section('ready_js')
    var last_subject  = '{{ Auth::user()->last_subject ? Auth::user()->last_subject : '' }}';
    var files = [];
    var editors = [];
    var max = 0;
    var block_id = 0;
    var tests = [];
    var openedBlock;

    $('.summernote').summernote({
        height: 300
    });

    var onChangeTab = function(e){
        var id = $(e.target).attr('aria-controls');
        editors[id].focus();
        editors[id].navigateFileEnd();
    };

    $('.date').datetimepicker({
        language: 'sk',
    });

    $('#save').on('click', function(e){
        e.preventDefault();
        if(!last_subject){
            var div = $('<div />').attr({
                'class': 'col-md-10'
            }).append($('<div />').attr('class', 'alert alert-danger alert-dismissible fade in').attr('role', 'alert').html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Nie je vybratý predmet'));
            $('#leftMenu').after(div)
            return;
        }
        var l = Ladda.create(this);
        l.start();
        $(this).removeClass('btn-danger').addClass('btn-primary');
        var filesData = [ ];
        editors.forEach(function(val, index){
            filesData.push({ 'name': val.name, 'text': val.getSession().getValue(), 'header': files[index]['header'] });
        });
        $.ajax({
            url: '{{ URL::action('TaskController@add') }}',
            method: 'post',
            dataType: 'json',
            data: {
                'name': $('#name').val(),
                'start': $('#start').val(),
                'deadline': $('#deadline').val(),
                'groupsize': $('#groupsize').val(),
                'text': $('.summernote').code(),
                'files': filesData,
                'tests': tests
            },
            success: function(answer){
                console.log(answer);
                if(answer['result']){
                    $('#name').val('');
                    $('#start').val('');
                    $('#deadline').val('');
                    $('#groupsize').val('');
                    $('.summernote').summernote().code('');
                }else{
                    $('#save').removeClass('btn-primary').addClass('btn-danger');
                }
            },
            error: function(){
                $('#save').removeClass('btn-primary').addClass('btn-danger');
            }
            }).always(function(){
                l.stop();
            });
        });

    $('#showAddFile').on('click', function(){
        $('#filename').val('');
        $('#header').attr('checked', false);
        $('#addFile').modal('show');
    });

    $('#showAddBlock').on('click', function(){
        $('#blockname').val('');
        $('#addBlock').modal('show');
    });

    var deleteEditor = function(id){
        if($('#editors-panel a[aria-controls=' + id + ']').parent().attr('class')){
            $('#editors-panel li[role=presentation]:first-of-type').attr('class', 'active');
            $('#editors-panel div[role=tabpanel]:first-of-type').attr('class', 'tab-pane active');
        }
        $('#' + id).remove();
        $('#editors-panel a[aria-controls=' + id + ']').parent().remove();
        var i;
        files.forEach(function(val, index){
            if(val['id'] == id){
                i = index;
            }
        });
        files.splice(i, 1);
        editors.forEach(function(val, index){
            if(val['id'] == id){
                i = index;
            }
        });
        editors.splice(i, 1);
    };

    var addEditor = function(id, name, text){
        editors[id] = ace.edit('editor' + id);

        editors[id].setOptions({
            enableBasicAutocompletion: true
        });

        editors[id].setTheme("ace/theme/merbivore");
        editors[id].getSession().setMode("ace/mode/c_cpp");
        editors[id].$blockScrolling = Infinity;
        if(text){
            editors[id].setValue(text);
        }
        editors[id]['id'] = id;
        editors[id]['name'] = name;
    };

    var appendFile = function(param){
        $('#editors-panel li[role=presentation]').removeClass('active');
        var li = $('<li />').attr({
            'role': 'presentation',
            'class': 'active'
        }).append($('<a />').attr({
            'href': '#' + param['id'],
            'aria-controls': param['id'],
            'role': 'tab',
            'data-toggle': 'tab',
        }).text(param['name']+' ').on('shown.bs.tab', function (e) {
            onChangeTab(e);
        }).append($('<span />').attr({
            'class': 'glyphicon glyphicon-remove text-danger',
            'aria-hidden': 'true'
        }).on('click', function(e){
            deleteEditor(param['id']);
            return false;
        })));
        $(li).insertBefore('#showAddFile');

        $('#editors-panel div[role=tabpanel]').removeClass('active');
        var div = $('<div />').attr({
            'role': 'tabpanel',
            'class': 'tab-pane active',
            'id': param['id']
        }).append($('<div />').attr({
            'class': 'panel-body'
        }).append($('<div />').attr({
            'class': 'editor',
            'id': 'editor'+param['id']
        })));
        $('#editors').append(div);

        addEditor(param['id'], param['name'], param['text']);
    };

    $('#addFileButton').on('click', function(){
        if($('#filename').val() != ''){
            $('#addFile').modal('hide');
            var obj = { 'id': max, 'name': $('#filename').val(), 'header': ($('#header').is(':checked') ? 1 : 0) };
            files.push(obj);
            appendFile(obj);
            max++;
        }
    });

    $('#filename').on('keydown', function(e){
        if(e.which==13){
            $('#addFileButton').trigger('click');
            return false;
        }
    });
    
    var addTest = function(param){
        console.log(param);
        tests.forEach(function(val, index){
            if(val['id'] == param['blockid']){
                val['section'].forEach(function(v, ind){
                    if(v['id'] == param['id']){
                        v['tests'].push(param);
                        $('.' + param['blockid'] + param['id'] + ' tbody').append($('<tr />').attr({
                            'class': '' + param['blockid'] + param['id'] + v['max']
                        }).append($('<td />').text(param['codebefore']))
                        .append($('<td />').text(param['testfunction']))
                        .append($('<td />').attr({
                            'class': 'text-center'
                        }).text(function(){
                            switch(param['compare']){
                                case "{{ Test::EQUAL }}":
                                    return '==';
                                case "{{ Test::NON_EQUAL }}":
                                    return '!=';
                            };
                        }))
                        .append($('<td />').text(param['expected']))
                        .append($('<td />').text(param['codeafter']))
                        .append($('<td />').attr({
                            'class': 'text-center'
                        }).append($('<button />').attr({
                            'class': 'btn btn-default btn-sm',
                            'type': 'button'
                         }).append($('<span />').attr({
                            'class': 'glyphicon glyphicon-edit',
                            'aria-hidden': 'true'
                         }))).append(' ').append($('<button />').attr({
                            'class': 'btn btn-danger btn-sm',
                            'type': 'button'
                         }).append($('<span />').attr({
                            'class': 'glyphicon glyphicon-remove',
                            'aria-hidden': 'true'
                         }))))
                        );
                        v['max']++;
                    }
                });
            }
        });
    };
    
    var removeSection = function(param){
        var i;
        tests.forEach(function(val){
            if(val['id'] == param['blockid']){
                val['section'].forEach(function(section, index){
                    if(section['id'] == param['id']){
                        i = index;
                    }
                });
                val['section'].splice(i, 1);
            }
        });
        $('.' + param['blockid']  + param['id']).remove();
    };
    
    var addSection = function(param){
        var blockId = param['id'];
        var block = $('#b' + param['id'] + ' .pull-right').parent();
        var blockVal;
        tests.forEach(function(val){
            if(val['id'] == blockId){
                blockVal = val;
            }
        });
        param['id'] = blockVal['max'];
        blockVal['max']++;
        blockVal['section'].push(param)
        var h3 = $('<h3 />').attr({
            'class': '' + blockId + param['id']
        }).text(param['name'] + ' ').append($('<button />').attr({
            'type': 'button',
            'class': 'btn btn-danger btn-sm',
        }).on('click', function(){
            var data = { 'blockid': blockId, 'id': param['id'] };
            removeSection(data);
        }).append($('<span />').attr({
            'class': 'glyphicon glyphicon-remove',
            'aria-hidden': 'true'
        })));
        
        var table = $('<table />').attr({
            'class': 'table table-striped ' + blockId + param['id']
            }).append($('<thead />').append($('<tr />').append($('<th />').text('Kód pred'))
            .append($('<th />').text('Testovaná funkcia'))
            .append($('<th />').text('Porovnanie').attr({ 'class': 'text-center' }))
            .append($('<th />').text('Očakávaná hodnota'))
            .append($('<th />').text('Kód po'))
            .append($('<th />').attr({ 'class': 'text-center' }).append($('<button />').attr({
                'type': 'button',
                'class': 'btn btn-success btn-sm'
            }).on('click', function(){
                $('#codebefore, #testfunction, #expected, #codeafter').val('');
                $('#compare').val('{{ Test::EQUAL }}');
                openedBlock = { 'blockid': blockId, 'id': param['id'] };
                $('#addTest').modal('show');
            }).append($('<span />').attr({
                'class': 'glyphicon glyphicon-plus',
                'aria-hidden': 'true'
            })))))).append($('<tbody />'));
        block.append(h3);
        block.append(table);
        return { 'blockid': blockId, 'id': param['id'] };
    };
    
    var deleteBlock = function(id){
        var i;
        tests.forEach(function(val, index){
            if(val['id'] == id){
                i = index;
            }
        });
        tests.splice(i, 1);
        if($('#blocks-panel a[aria-controls=b' + id + ']').parent().attr('class')){
            $('#blocks-panel li[role=presentation]:first-of-type').attr('class', 'active');
            $('#blocks-panel div[role=tabpanel]:first-of-type').attr('class', 'tab-pane active');
        }
        $('#blocks-panel a[aria-controls=b' + id + ']').parent().remove();
        $('#b' + id).remove();
    };
    
    var appendBlock = function(param){
        $('#blocks-panel li[role=presentation]').removeClass('active');
        var li = $('<li />').attr({
            'role': 'presentation',
            'class': 'active'
        }).append($('<a />').attr({
            'href': '#b' + param['id'],
            'aria-controls': 'b' + param['id'],
            'role': 'tab',
            'data-toggle': 'tab',
        }).text(param['name']+' ').append($('<span />').attr({
            'class': 'glyphicon glyphicon-remove text-danger',
            'aria-hidden': 'true'
        }).on('click', function(e){
            deleteBlock(param['id'])
            return false;
        })));
        $(li).insertBefore('#showAddBlock');

        $('#blocks-panel div[role=tabpanel]').removeClass('active');
        
        var div = $('<div />').attr({
            'role': 'tabpanel',
            'class': 'tab-pane active',
            'id': 'b' + param['id']
        }).append($('<div />').attr({
            'class': 'panel-body'
        }).append($('<h4 />').attr({
            'class': 'pull-right'
        }).text('Pridaj sekciu ').append($('<button />').attr({
            'type': 'button',
            'class': 'btn btn-success btn-sm'
        }).on('click', function(){
            openedBlock = param['id'];
            $('#sectionname').val('');
            $('#points').val('');
            $('#addSection').modal('show');
        }).append($('<span />').attr({
            'class': 'glyphicon glyphicon-plus',
            'aria-hidden': 'true'
        })))));
        tests.push(param);
        $('#blocks').append(div);
    };
    
    
    $('#addBlockButton').on('click', function(){
        if($('#blockname').val() != ''){
            var param = { 'name': $('#blockname').val(), 'id': block_id, 'section': [], 'max': 0 };
            appendBlock(param);
            block_id++;
            $('#addBlock').modal('hide');
        }
    });

    $('#blockname').on('keydown', function(e){
        if(e.which==13){
            $('#addBlockButton').trigger('click');
            return false;
        }
    });
    
    $('#addSectionButton').on('click', function(){
        if($('#sectionname').val() != '' && $('#points').val() != '' && ($('#points').val()%1)===0 && $('#points').val() > 0){
            var param = { 'id': openedBlock, 'name': $('#sectionname').val(), 'points': $('#points').val(), 'tests': [], 'max': 0 };
            addSection(param);
            $('#addSection').modal('hide');
        }
    });

    $('#sectionname, #points').on('keydown', function(e){
        if(e.which==13){
            $('#addSectionButton').trigger('click');
            return false;
        }
    });
    
    $('#addTestButton').on('click', function(){
        if($('#testfunction').val() && $('#expected').val() != ''){
            var param = openedBlock;
            param['codebefore'] = $('#codebefore').val();
            param['testfunction'] = $('#testfunction').val();
            param['compare'] = $('#compare').val();
            param['expected'] = $('#expected').val();
            param['codeafter'] = $('#codeafter').val();
            addTest(param);
            $('#addTest').modal('hide');
        }
    });

    $('#codebefore, #testfunction, #compare, #expected, #codeafter').on('keydown', function(e){
        if(e.which==13){
            $('#addTestButton').trigger('click');
            return false;
        }
    });
    
    @if(isset($id))
        var loadData = function(){
            $.ajax({
                'url': "{{ action('TaskController@loadData') }}",
                'method': 'post',
                'dataType': 'json',
                'data': {
                    'id': {{ $id }}
                },
                'success': function(data){
                    $('#name').val(data.name);
                    $('#start').val(data.start);
                    $('#deadline').val(data.deadline);
                    $('#groupsize').val(data.groupsize);
                    $('.summernote').code(data.text);
                    data.files.forEach(function(val){
                        var obj = { 'id': max, 'name': val.name, 'header': val.header, 'text': val.text };
                        files.push(obj);
                        appendFile(obj);
                        max++;
                    });
                    data.blocks.forEach(function(val){
                        var param0 = { 'name': val.name, 'id': block_id, 'section': [], 'max': 0 };
                        appendBlock(param0);
                        val.sections.forEach(function(section){
                            var param1 = { 'id': block_id, 'name': section.name, 'points': section.points, 'tests': [], 'max': 0 };
                            tmp = addSection(param1);
                            section.tests.forEach(function(test){
                                var param2 = tmp;
                                param2['codebefore'] = test.codebefore;
                                param2['testfunction'] = test.testfunction;
                                param2['compare'] = test.compare;
                                param2['expected'] = test.expected;
                                param2['codeafter'] = test.codeafter;
                                addTest(param2);
                            });
                        });
                        block_id++;
                    });
                }
            });
        };
        loadData();
    @endif
@stop

@section('center')
<div class="col-md-12">
    <form class="form-horizontal clearfix" role="form">
        <div class="form-group">
            <label for="name" class="col-md-2 control-label">{{ Lang::get('Názov zadania') }}</label>
            <div class="col-md-10">
                <input type="text" id="name" placeholder="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="start" class="col-md-2 control-label">{{ Lang::get('Začiatok zadania') }}</label>
            <div class="col-md-10">
                <div class="input-group date">
                    <input type="text" class="form-control" placeholder="" maxlength="10" id="start">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="deadline" class="col-md-2 control-label">{{ Lang::get('Koniec zadania') }}</label>
            <div class="col-md-10">
                <div class="input-group date">
                    <input type="text" class="form-control" placeholder="" maxlength="10" id="deadline">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="groupsize" class="col-md-2 control-label">{{ Lang::get('Veľkosť skupiny') }}</label>
            <div class="col-md-10">
                <input type="text" id="groupsize" placeholder="{{ Lang::get('') }}" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">{{ Lang::get('Text zadania') }}</label>
            <div class="col-md-10">
                <div class="summernote"></div>
            </div>
        </div>       

        <div class="panel panel-default" id="editors-panel">
            <div class="panel-heading">
                <h3 class="panel-title">Súbory</h3>
            </div>
            <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="noselect" id="showAddFile">
                        <a>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="editors">
                </div>
            </div>
        </div>
        <div class="panel panel-default" id="blocks-panel">
            <div class="panel-heading">
                <h3 class="panel-title">Testovacie bloky</h3>
            </div>
            <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="noselect" id="showAddBlock">
                        <a>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="blocks"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-1 col-md-offset-10">
                <button class="btn btn-primary ladda-button" id="save" data-style="zoom-in">
                    <span class="ladda-label">{{ Lang::get('Ulož') }}</span>
                </button>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pridanie súboru</h4>
            </div>
            <div class="modal-body" id="addFileBody">
                <form role="form">
                    <div class="form-group">
                        <label for="filename" class="control-label">{{ Lang::get('Názov súboru') }}:</label>
                        <input type="text" class="form-control" id="filename">
                        <div class="checkbox">
                            <label class="control-label">
                                <input type="checkbox" id="header"> Hlavičkový súbor
                            </label>
                      </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary" id="addFileButton">Pridaj súbor</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addBlock" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pridanie testovacieho bloku</h4>
            </div>
            <div class="modal-body" id="addBlockBody">
                <form role="form">
                    <div class="form-group">
                        <label for="blockname" class="control-label">{{ Lang::get('Názov bloku') }}:</label>
                        <input type="text" class="form-control" id="blockname">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary" id="addBlockButton">Pridaj blok</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addSection" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pridanie sekcie</h4>
            </div>
            <div class="modal-body" id="addSectionBody">
                <form role="form">
                    <div class="form-group">
                        <label for="sectionname" class="control-label">{{ Lang::get('Názov sekcie') }}:</label>
                        <input type="text" class="form-control" id="sectionname">
                        <label for="points" class="control-label">{{ Lang::get('Počet bodov') }}:</label>
                        <input type="text" class="form-control" id="points">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button type="button" class="btn btn-primary" id="addSectionButton">Pridaj sekciu</button>
            </div>
        </div>
    </div>
</div>
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