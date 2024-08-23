<div class="form-group mb-3">
    <label class="mb-1" for="{{ $name }}">{{ __($label) }}
        @if ($attributes->has('required'))
            <span class="text-danger"> *</span>
        @endif
    </label>
    @if ($attributes->has('value'))
    <textarea class="form-control" name="{{ $name }}" id="{{ $name }}" cols="30" rows="@if($attributes->has('row')){{ $row }}@else 2 @endif">{{ $value }}</textarea>
    @else
    <textarea class="form-control" name="{{ $name }}" id="{{ $name }}" cols="30" rows="@if($attributes->has('row')){{ $row }}@else 2 @endif"></textarea>
    @endif
    <span class="text-danger invalid {{ $name }}"></span>
</div>
