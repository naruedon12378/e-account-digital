@if (Auth::user()->hasAnyPermission($permissions))
    <div class="px-2 mb-2">
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
        @if ($new['url'])
            <a href="{{ url($new['url']) }}" id="{{ $new['id'] }}" class="btn {{ env('BTN_OUTLINE_THEME') }}">
                <i class="fas fa-plus mr-2"></i>
                {{ __('home.add') }}
            </a>
        @else
            <a href="javascript:;" id="{{ $new['id'] }}" class="btn {{ env('BTN_OUTLINE_THEME') }}">
                <i class="fas fa-plus mr-2"></i>
                {{ __('home.add') }}
            </a>
        @endif

    </div>
@endif
