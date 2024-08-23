<div class="form-group mb-3">
    <label class="mb-1" for="{{ $name }}">{{ __($label) }} <span class="text-danger @if(!$isRequired) d-none @endif"> *</span></label>
    <textarea class="form-control" name="{{ $name }}" id="{{ $name }}" cols="30" rows="{{ $row }}">{{ $value }}</textarea>
    <span class="text-danger invalid {{ $name }}"></span>
</div> 