@extends('layouts.center_content')

@section('center')
<div class="col-md-6 col-md-offset-3">
    @forelse(Auth::user()->lastSubject->task()->get() as $task)
    {{{ $task->name }}}
    {{{ $task->text}}}
    @empty
        .Nič na zobrazenie
    @endforelse
</div>
@stop