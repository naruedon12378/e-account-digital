<div class="form-group mb-3">
    <label class="mb-1" for="{{ $name }}">{{ __($label) }}
        @if ($attributes->has('required'))
            <span class="text-danger"> *</span>
        @endif
    </label>
    <select class="form-control @if ($attributes->has('class')) {{ $class }} @endif" name="{{ $name }}"
        id="{{ $name }}" @if ($attributes->has('required')) required @endif>
        <option value="">{{ __($selectoption) }}</option>

        @if ($attributes->has('data'))
            @foreach ($value as $key => $company)
                <option value="{{ $company->id }}" @if ($company->id == $selectedvalue) selected @endif>{{ $company->name_en }}</option>
            @endforeach
        @endif
    </select>
    <span class="text-danger invalid {{ $name }}"></span>
</div>
