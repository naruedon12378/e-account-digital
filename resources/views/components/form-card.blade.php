<div class="card {{ config('adminlte.classes_card.theme') }} @if($attributes->has('class')) {{ $class }}@endif">
    {{ $slot }}
</div>