<li class="nav-item dropdown">
    @if (app()->getLocale() == 'th')
        <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown">
            <i class="flag-icon flag-icon-th mr-2 "></i>
            ไทย
        </a>
    @else
        <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown">
            <i class="flag-icon flag-icon-us mr-2 "></i>
            English
        </a>
    @endif
    <ul class="dropdown-menu border-0 shadow">
        <li>
            <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('en') }}">
                <i class="flag-icon flag-icon-us mr-2 "></i>
                English
            </a>

        </li>
        <li class="active">
            <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('th') }}">
                <i class="flag-icon flag-icon-th mr-2 "></i>
                ไทย
            </a>
        </li>
    </ul>
</li>
