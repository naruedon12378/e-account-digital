@if ($attributes->has('class'))
<div class="d-flex justify-content-{{ $class }}">    
@else
<div class="d-flex justify-content-between">
@endif
    <div>{{ $label }}</div>
    <div class="px-1">:</div>
</div>
