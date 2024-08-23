<div class="form-group mb-3">
    <label class="mb-1" for="{{ $name }}">{{ __($label) }}
        @if ($attributes->has('required'))
            <span class="text-danger"> *</span>
        @endif
    </label>
    <select class="form-control @if ($attributes->has('class')) {{ $class }} @endif" name="{{ $name }}"
        id="{{ $name }}" @if ($attributes->has('required')) required @endif>
        <option value="" disabled>{{ __($selectoption) }}</option>
        @if ($attributes->has('data'))
            @foreach ($data as $key => $val)
                @if ($attributes->has('value'))
                    <option value="{{ $key }}" @if ($key ==  $value || $key == 'pending') selected @else disabled @endif> {{ $val }}</option>
                @else
                    <option value="{{ $key }}" @if ($key ==  $value || $key == 'pending') selected @else disabled @endif >{{ $val }}</option>
                @endif
            @endforeach
        @endif
    </select>
    <span class="text-danger invalid {{ $name }}"></span>
</div>
