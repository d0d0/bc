@extends('layouts.center_content')

@section('center')
<div class="col-md-12">
    <table class="table table-striped table-hover">
        <tr>
            <th>Názov</th>
            <th>Začiatok</th>
            <th>Koniec</th>
            <th>Bodov</th>
        </tr>
        @forelse($tasks as $task)
        <tr {{ $task->isAfterDeadline() ? 'class="danger"' : '' }}>
            <td>
                {{ HTML::linkAction('SolutionController@show', $task->name, array('id' => $task->id)) }}
            </td>
            <td>{{{ $task->formattedStart() }}}</td>
            <td>{{{ $task->formattedDeadline() }}}</td>
            <td>{{{ $task->points() }}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">
                .Nič na zobrazenie
            </td>
        </tr>
        @endforelse
    </table>
</div>
@stop