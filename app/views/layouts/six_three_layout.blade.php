@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-2">
        @yield('left')
    </div>
    <div class="col-md-3">
        @yield('right')
    </div>
</div>
@stop