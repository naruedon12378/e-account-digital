@if ($data)
    @foreach ($data as $val)
        <div class="icheck-primary icheck-inline">
            <input type="radio" name="{{ $name }}" id="{{ $val['value'] }}" value="{{ $val['value'] }}"
                {{ $val['checked'] }} />
            <label for="{{ $val['value'] }}">{{ __($val['label']) }}</label>
        </div>
    @endforeach
@endif