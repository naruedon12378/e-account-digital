<div class="custom-control custom-switch @if($attributes->has('class')) {{ $class }} @endif">
    <input type="checkbox"
        class="custom-control-input"
        id="customSwitch{{ $id }}" 
        value="{{ $value }}"
        @if($attributes->has('checked')) checked @endif
        >
    <label class="custom-control-label" for="customSwitch{{ $id }}">
        @if ($attributes->has('label'))
            {{ $label }}
        @endif
    </label>
</div>
