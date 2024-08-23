<a href="@if($attributes->has('url')){{ $url }}@else javascript:; @endif"
    class="btn btn-outline-secondary px-5 @if ($attributes->has('class')) {{ $class }} @endif"
    data-id="@if ($attributes->has('dataId')) {{ $dataId }} @endif">
    {{ $slot }}
</a>
