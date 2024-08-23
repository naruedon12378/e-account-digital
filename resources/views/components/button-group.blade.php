<div class="btn-group">
    <button type="button" id="btnSubmit" class="btn btn-outline-{{ $color }} @if($attributes->has('class')) {{ $class }} @endif">{{ $label }}</button>
    <button type="button" class="btn btn-outline-{{ $color }} dropdown-toggle @if($attributes->has('class')) {{ $class }} @endif" data-toggle="dropdown">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu dropdown-menu-right" role="menu">
        {{ $slot }}
    </div>
</div>