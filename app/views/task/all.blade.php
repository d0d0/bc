@extends('layouts.center_content')

@section('center')
<div class="col-md-12">
    <table class="table table-striped">
        <tr>
            <th>.Názov</th>
            <th>.Začiatok</th>
            <th>.Koniec</th>
            <th>.Bodov</th>
        </tr>
        @forelse(Auth::user()->lastSubject->task()->orderBy('deadline')->get() as $task)
        <tr {{ Carbon::parse($task->deadline) < Carbon::now() ? 'class="danger"' : '' }}>
            <td>{{{ $task->name }}}</td>
            <td>{{{ Carbon::parse($task->start)->format('d.m.Y H:m') }}}</td>
            <td>{{{ Carbon::parse($task->deadline)->format('d.m.Y H:m') }}}</td>
            <td>{{{ Carbon::now()->format('d.m.Y H:m') }}}</td>
        </tr>
        @empty
        .Nič na zobrazenie
        @endforelse
    </table>
</div>
@stop