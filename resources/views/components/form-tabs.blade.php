 <ul class="nav nav-tabs" role="tablist">
    @foreach ($tabs as $key => $value)
        <li class="nav-item">
            <a class="nav-link @if($key == 'home') active @endif" data-toggle="tab" href="#{{ $key }}">{{ $value }}</a>
        </li>    
    @endforeach
</ul>

<div class="tab-content">
    {{ $slot }}
</div>