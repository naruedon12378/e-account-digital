@if (Auth::user()->hasAnyPermission($permissions))
    <a href="{{ url($url) }}" class="font-bold">{{ $name }}</a>
@endif