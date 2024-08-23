{{-- <div class="btn-group">
    <button type="button" class="btn btn-outline-success">{{ $label }}</button>
    <button type="button" class="btn btn-outline-success dropdown-toggle"
        data-toggle="dropdown">
    </button>
    <div class="dropdown-menu" role="menu">
        {{ $slot }}
    </div>
</div> --}}

<div class="dropdown mr-2">
    <button type="button" class="btn btn-outline-{{ $color }} dropdown-toggle" data-toggle="dropdown">
        {!! $label !!}
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        {{ $slot }}
    </div>
</div>
