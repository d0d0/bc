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
                @if(Auth::user()->isTeacher())
                <th class="text-center">Edituj</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <?php $points = 0 ?>
            <?php $total_points = 0 ?>
            @forelse($tasks as $task)
            <tr {{ $task->isAfterDeadline() ? 'class="danger"' : '' }}>
                <td>
                    {{ HTML::linkAction('SolutionController@show', $task->name, array('id' => $task->id)) }}
                </td>
                <td>{{{ $task->formattedStart() }}}</td>
                <td>{{{ $task->formattedDeadline() }}}</td>
                <td>{{{ $task->groupPoints() . ' / ' . $task->points() }}}</td>
                @if(Auth::user()->isTeacher())
                <td class="text-center text-info">
                    <a href="{{ action('TaskController@edit', array('id' => $task->id)) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                </td>
                @endif
            </tr>
            <?php $points += $task->points() ?>
            <?php $total_points += $task->groupPoints() ?>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isTeacher() ? 5 : 4 }}">
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
                <th>{{{ $total_points . ' / ' . $points }}}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
@stop