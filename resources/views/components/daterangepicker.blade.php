<div class="input-group @if ($attributes->has('class')) {{ $class }} @endif">
    <div class="input-group-prepend">
        <span class="input-group-text">
            <i class="far fa-calendar-alt"></i>
        </span>
    </div>
    <input type="text" class="form-control daterangepicker-field" id="{{ $name }}" name="{{ $name }}">
</div>

@push('js')
    <script>
        var fromDate = "{{ $from }}";
        var toDate = "{{ $to }}";

        $('input[name="{{ $name }}"]').daterangepicker({
            "startDate": fromDate,
            "endDate": toDate,
            locale: {
                format: 'YYYY/MM/DD'
            }
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY/MM/DD') + ' to ' + end.format(
                'YYYY/MM/DD') + ' (predefined range: ' + label + ')');
        });
    </script>
@endpush
