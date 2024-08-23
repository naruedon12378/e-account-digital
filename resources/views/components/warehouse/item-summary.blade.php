<div class="col-sm-4 mb-3 text-right">{{ __($labelname) }}</div>
<div class="col-sm-8 mb-3 text-right">
    <input type="text" {{ $isreadonly }} class="calSection text-right {{ $classname }}" name="{{ $inputname }}"
        value="{{ $inputvalue }}">
        @if ($isneedcurrency)
            {{ __($currency) }}
        @endif
</div>


