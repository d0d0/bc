@extends('layouts.center_content')

@section('style')
{{ HTML::script('js/spin.min.js') }}
{{ HTML::script('js/ladda.min.js') }}
{{ HTML::style('css/ladda-themeless.min.css') }}
@stop

@section('center')
<div class="col-md-12">
    <form class="form-horizontal clearfix" role="form">
        <div class="form-group">
            <label for="name" class="col-md-1 control-label">{{ Lang::get('article.name') }}</label>
            <div class="col-md-11">
                <input type="text" id="name" placeholder="{{ Lang::get('article.name') }}" class="form-control" value="">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-1 col-md-offset-10">
                <button class="btn btn-primary ladda-button" id="save" data-style="zoom-in">
                    <span class="ladda-label">{{ Lang::get('.Ulož') }}</span>
                </button>
            </div>
        </div>
    </form>
</div>
@stop