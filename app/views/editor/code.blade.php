@extends('layouts.master')

@section('js')
{{ HTML::script('js/prettify/prettify.js') }}
{{ HTML::style('css/prettify.css') }}
@stop

@section('style')

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
    prettyPrint();
@stop

@section('content')
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
                    <pre class="prettyprint lang-cc">
                        {{{ $file->text }}}
                    </pre>
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
@stop