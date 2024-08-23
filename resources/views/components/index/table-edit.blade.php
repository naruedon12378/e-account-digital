@if (Auth::user()->hasAnyPermission($permissions))
    @if ($url)
        <a href="{{ url($url) }}" class="btn btn-outline-success btn-sm js-edit" data-id="{{ $id }}">
            <i class="fas fa-edit"></i> แก้ไข
        </a>
    @else
        <a href="javascript:;" class="btn btn-outline-success btn-sm js-edit" data-id="{{ $id }}">
            <i class="fas fa-edit"></i> แก้ไข
        </a>
    @endif

@endif
