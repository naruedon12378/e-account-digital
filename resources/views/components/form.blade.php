@if($attributes->has('enctype'))
<form id="{{ $name }}" action="@if($attributes->has('action')){{ $action }}@endif" method="POST" enctype="multipart/form-data">
@else
<form id="{{ $name }}" action="{{ $action }}" method="POST">
@endif    
    @csrf
    {{ $slot }}
</form>