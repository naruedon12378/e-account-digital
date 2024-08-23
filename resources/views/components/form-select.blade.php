<div class="form-group mb-3">
    @if ($attributes->has('label'))
    <label class="mb-1" for="{{ $name }}">{{ __($label) }}
        @if ($attributes->has('required'))
            <span class="text-danger"> *</span>
        @endif
    </label>
    @endif
    <select class="form-control @if ($attributes->has('class')) {{ $class }} @endif" name="{{ $name }}"
        id="{{ $name }}" @if ($attributes->has('required')) required @endif>
        <option value="" disabled>Select...</option>
        @if ($attributes->has('data'))
            @foreach ($data as $key => $val)
                @if ($attributes->has('value'))
                    <option value="{{ $key }}" @if ($key == $value) selected @endif>
                        {{ $val }}</option>
                @else
                    <option value="{{ $key }}">{{ $val }}</option>
                @endif
            @endforeach
        @endif
    </select>
    <span class="text-danger invalid {{ $name }}"></span>
</div>
