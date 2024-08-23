@if (Auth::user()->hasAnyPermission($permissions))
    @if ($url)
        <a href="{{ url($url) }}" class="btn btn-outline-primary btn-sm js-duplicate" data-id="{{ $id }}">
            <i class="far fa-clone"></i> คัดลอก
        </a>
    @else
        <a href="javascript:;" class="btn btn-outline-primary btn-sm js-duplicate" data-id="{{ $id }}">
            <i class="far fa-clone"></i> คัดลอก
        </a>
    @endif

@endif
