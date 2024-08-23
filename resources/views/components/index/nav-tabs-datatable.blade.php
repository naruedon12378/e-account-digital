<ul id="tabBarDataTable" class="nav nav-tabs mb-3">
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

@push('js')
    <script>
        $('#tabBarDataTable a').on('click', function(){
            let tab_key = $(this).attr('data-id');
            // $('#frmIndex input[name="teb_key"]').val(status);
            // $('#frmIndex').submit();
            if ('URLSearchParams' in window) {
                    const url = new URL(window.location)
                    if( tab_key && tab_key != '' ){
                        url.searchParams.set('tabkey', tab_key)
                    }else{
                        url.searchParams.delete('tabkey')
                    }
                    history.pushState(null, '', url);
                }

                // location.reload();
                table.ajax.reload();
        });
    </script>
@endpush