<button type="button" class="btn btn-outline-success @if ($attributes->has('class')) {{ $class }} @endif"
    data-toggle="modal" data-target="#{{ $modal }}">
    {{ $slot }}
</button>
