<div class="form-group mb-3">
    <label class="mb-1" for="{{ $name }}">{{ __($label) }} <span class="text-danger @if(!$isRequired) d-none @endif"> *</span></label>
    <input
        class="form-control"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if( isset($min) ) min="{{ $min }}" @endif
        @if( isset($max) ) max="{{ $max }}" @endif
        autocomplete="{{ isset($autocomplete) ? $autocomplete : 'on' }}"
        placeholder="{{ __(@$placeholder) }}"
        {!! $property !!}
    >
    <span class="text-danger invalid {{ $name }}"></span>
</div>
