<ul id="tabBar" class="nav nav-tabs mb-3">
    @foreach ($tabs as $tab)
        <li class="nav-item">
            <a class="nav-link {{ $tab->class }}" data-toggle="pill" href="javascript:;" aria-selected="true"
                data-id="{{ $tab->value }}">
                {{ $tab->label }}
                @if ($tab->value > 0)
                    <span class="badge bg-{{ $tab->color }} ml-2">{{ $tab->count }}</span>
                @endif
            </a>
        </li>
    @endforeach
</ul>

{{-- <form id="frmSearch" action="" method="get">
    <input type="hidden" name="type">
</form> --}}

@push('js')
    <script>
        $('#tabBar a').on('click', function(){
            let status = $(this).attr('data-id');
            $('#frmIndex input[name="status"]').val(status);
            $('#frmIndex').submit();
        });
    </script>
@endpush