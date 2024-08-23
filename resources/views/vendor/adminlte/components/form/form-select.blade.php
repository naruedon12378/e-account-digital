<div class="form-group mb-3">
    <label class="mb-1" for="{{ $name }}">{{ __($label) }} <span
            class="text-danger @if (!$isRequired) d-none @endif"> *</span></label>
    <select class="form-control {{ $class }}" name="{{ $name }}" id="{{ $name }}" >
        <option value="">Select...</option>
        @if ($data)
            @foreach ($data as $key => $val)
                <option value="{{ $key }}" @if($key == $value) selected @endif>{{ $val }}</option>
            @endforeach
        @endif
    </select>
    <span class="text-danger invalid {{ $name }}"></span>
</div>
