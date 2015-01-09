@if($files->isEmpty())
.Žiadny súbor na obnovenie
@else
<div class="list-group">
    @foreach($files as $file)
    <a href="javascript:void(0)" onclick="$(this).toggleClass('active');" class="list-group-item">{{{ $file->name }}}</a>
    @endforeach
</div>
@endif