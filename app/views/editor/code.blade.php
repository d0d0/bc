@extends('layouts.master')

@section('js')
{{ HTML::script('js/prettify/prettify.js') }}
{{ HTML::style('css/prettify.css') }}
@stop

@section('style')

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
    prettyPrint();
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
                    <pre class="prettyprint lang-cc">{{{ $file->text }}}</pre>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop