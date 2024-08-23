<div class="d-flex justify-content-between flex-wrap mb-2 px-2">
    @if (Auth::user()->hasAnyPermission($permissions))
        <div>
            @if( isset($new) )
                @if ($new['url'])
                    <a href="{{ url($new['url']) }}" id="{{ $new['id'] }}" class="btn {{ env('BTN_OUTLINE_THEME') }}">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __($new['label']) }}
                    </a>
                @else
                    <a href="javascript:;" id="{{ $new['id'] }}" class="btn {{ env('BTN_OUTLINE_THEME') }}">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __($new['label']) }}
                    </a>
                @endif
            @endif
            @if ($import['isActive'])
                <a href="{{ $import['url'] }}" class="btn btn-outline-success">
                    <i class="fas fa-file-import mr-2"></i>
                    Import
                </a>
            @endif
            @if ($export['isActive'])
                <a href="{{ $export['url'] }}" class="btn btn-outline-danger"><i class="fas fa-file-export mr-2"></i>
                    Export
                </a>
            @endif

            @if ($print['isActive'])
                <a href="javascript:;" id="btnPrintAll" class="btn btn-outline-primary"><i
                        class="fa-solid fa-print"></i>
                    Print
                </a>
            @endif
        </div>
    @endif
    <div id="totalSelected">
        Select 1 Items (Limit 20 items)
    </div>
</div>
