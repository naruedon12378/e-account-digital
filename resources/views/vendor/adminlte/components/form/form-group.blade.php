<div class="form-group mb-3">
    <label class="mb-1" for="{{ $name }}">{{ __($label) }} <span class="text-danger @if(!$isRequired) d-none @endif"> *</span></label>
    <input type="{{ $type }}"
        class="form-control"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        autocomplete="{{ isset($autocomplete) ? $autocomplete : 'on' }}"
        {!! $property !!}
    >
    <span class="text-danger invalid {{ $name }}"></span>
</div>
