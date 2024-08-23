<div id="accordion{{ $number }}"
    class="border-bottom border-success p-3 @if ($attributes->has('class')) {{ $class }} @endif">
    <a class="card-link d-flex justify-content-between" data-toggle="collapse" href="#collapse{{ $number }}">
        <h6>
            {{ $title }}
            @if ($attributes->has('message'))
                <x-tooltips title="{{ $message }}">
                </x-tooltips>
            @endif
        </h6>
        <h6>Show more/less</h6>
    </a>
    <div id="collapse{{ $number }}" class="collapse @if ($attributes->has('show')) show @endif"
        data-parent="#accordion{{ $number }}">
        {{ $slot }}
    </div>
</div>
