@extends('layouts.center_content')

@section('center')
<div class="col-md-12">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Názov</th>
                <th>Začiatok</th>
                <th>Koniec</th>
                <th>Bodov</th>
            </tr>
        </thead>
        <tbody>
            <?php $points = 0 ?>
            @forelse($tasks as $task)
            <tr {{ $task->isAfterDeadline() ? 'class="danger"' : '' }}>
                <td>
                    {{ HTML::linkAction('SolutionController@show', $task->name, array('id' => $task->id)) }}
                </td>
                <td>{{{ $task->formattedStart() }}}</td>
                <td>{{{ $task->formattedDeadline() }}}</td>
                <td>{{{ $task->points() }}}</td>
            </tr>
            <?php $points += $task->points() ?>
            @empty
            <tr>
                <td colspan="4">
                    Nič na zobrazenie
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>{{{ $points }}}</th>
            </tr>
        </tfoot>
    </table>
</div>
@stop