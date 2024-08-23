<button 
    @if ($attributes->has('type')) 
        typ="{{ $type }}"
    @else
        type="button"
    @endif
    @if ($attributes->has('id')) 
        id="{{ $id }}"
    @else
        id="btnSubmit" 
    @endif
    @if ($attributes->has('class'))
        class="btn btn-outline-{{ $class }}"
    @else
        class="btn btn-outline-success px-5"
    @endif
    @if ($attributes->has('dataId')) data-id="{{ $dataId }}" @endif
    @if($attributes->has('property')) {!! $property !!}@endif
    >
    {{ $slot }}
</button>