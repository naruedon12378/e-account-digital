<div class="form-group">
    <label class="mb-1" for="{{ $name }}">{{ __($label) }}
        @if ($attributes->has('required'))
            <span class="text-danger"> *</span>
        @endif
    </label>
    <div class="input-group @if ($attributes->has('class')) {{ $class }} @endif">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="far fa-calendar-alt"></i>
            </span>
        </div>
        <input type="text" class="form-control" id="{{ $name }}" name="{{ $name }}"
            value="{{ $value }}" @if ($attributes->has('required')) required @endif autocomplete="off">
    </div>
    <span class="text-danger invalid {{ $name }}"></span>
</div>

@push('js')
    <script>
        $('input[name="{{ $name }}"]').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endpush
