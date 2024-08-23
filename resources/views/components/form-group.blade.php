<div class="form-group mb-3">
    <label class="mb-1" for="{{ $name }}"> {{ __($label) }}
        @if ($attributes->has('required'))
            <span class="text-danger"> *</span>
        @endif
    </label>
    <input
        @if ($attributes->has('type'))
            type="{{ $type }}"
        @else
            type="text"
        @endif
        class="form-control" id="{{ $name }}" name="{{ $name }}"
        @if($attributes->has('value'))
            @if ( $attributes->has('type') && $type=='number' && $value>=0 )
                value="{{ $value }}"
            @else
                @if ($value) value="{{ $value }}" @endif
            @endif
        @endif
        @if ($attributes->has('required')) required @endif
        @if ($attributes->has('property')) {!! $property !!} @endif
        @if ($attributes->has('placeholder'))
            @if ($placeholder) placeholder="{{ __($placeholder) }}" @endif
        @endif
        @if ($attributes->has('autocomplete'))
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @endif
        @if( isset($min) ) min="{{ $min }}" @endif
        @if( isset($max) ) max="{{ $max }}" @endif
    >
    <span class="text-danger invalid {{ $name }}"></span>
</div>
