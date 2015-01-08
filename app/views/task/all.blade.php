@extends('layouts.center_content')

@section('center')
<div class="col-md-12">
    <table class="table table-striped table-hover">
        <tr>
            <th>.Názov</th>
            <th>.Začiatok</th>
            <th>.Koniec</th>
            <th>.Bodov</th>
        </tr>
        @forelse(Auth::user()->lastSubject->task()->orderBy('deadline')->get() as $task)
        <tr {{ Carbon::parse($task->deadline) < Carbon::now() ? 'class="danger"' : '' }}>
            <td>
                {{ HTML::linkAction('SolutionController@show', $task->name, array('id' => $task->id)) }}
            </td>
            <td>{{{ Carbon::parse($task->start)->format('d.m.Y H:i') }}}</td>
            <td>{{{ Carbon::parse($task->deadline)->format('d.m.Y H:i') }}}</td>
            <td>{{{ Carbon::now()->format('d.m.Y H:i') }}}</td>
        </tr>
        @empty
        <tr>
            <td>
                .Nič na zobrazenie
            </td>
        </tr>
        @endforelse
    </table>
</div>
@stop