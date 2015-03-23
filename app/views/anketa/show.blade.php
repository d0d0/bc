@extends('layouts.master')

@section('content')
{{ Form::open(array('action' => 'AnketaController@postAnketa', 'class' => 'form-horizontal thumbnail', 'method' => 'post', 'role' => 'form')) }}
<div>
    <p class="text-muted">Ako sa vám programovalo v skupine?</p>
    {{ Form::textarea('question1') }}
    <p class="text-muted">Použili ste už niekedy podobný skupinový editor?</p>
    {{ Form::textarea('question2') }}
    <p class="text-muted">Viete si predstaviť, že by sa tento editor využíval na cvičeniach?</p>
    {{ Form::textarea('question3') }}
    <p class="text-muted">Viete si predstaviť, že by ste takýmto spôsobom mali vypracovať nejaký projekt?</p>
    {{ Form::textarea('question4') }}
    <p class="text-muted">Máte nejaké nápady na vylepšenie aplikácii? Resp. aký komponent by bolo dobré pridať</p>
    {{ Form::textarea('question5') }}
    <p class="text-muted">Nájdené chyby</p>
    {{ Form::textarea('question6') }}
    <p class="text-muted">Dala by sa aplikácia vylepšiť tak, aby poskytovala lepší používateľský komfort?</p>
    {{ Form::textarea('question7') }}
    <p class="text-muted">Iné... (môžete vyjadriť svoj názor na svet)</p>
    {{ Form::textarea('question8') }}
</div>
{{ Form::submit('Odošli', array('class'=>'btn btn-default')) }}
{{ Form::close() }}
@stop