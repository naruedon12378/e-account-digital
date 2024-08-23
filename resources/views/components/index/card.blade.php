<div class="card shadow-custom @if($attributes->has('class')) {{ $class }} @endif">
    <div class="card-body">
       {{ $slot }}
    </div>
</div>