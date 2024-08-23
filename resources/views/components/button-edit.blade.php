<a href="{{ $url }}"
    class="btn btn-outline-primary px-5 @if ($attributes->has('class')) {{ $class }} @endif">
    {{ $slot }}
</a>
