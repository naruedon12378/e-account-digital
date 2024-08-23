@php($logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout'))
@php($profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout'))

@if (config('adminlte.usermenu_profile_url', false))
    @php($profile_url = Auth::user()->adminlte_profile_url())
@endif

@if (config('adminlte.use_route_url', false))
    @php($profile_url = $profile_url ? route($profile_url) : '')
    @php($logout_url = $logout_url ? route($logout_url) : '')
@else
    @php($profile_url = $profile_url ? url($profile_url) : '')
    @php($logout_url = $logout_url ? url($logout_url) : '')
@endif

<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" style="color: rgb(0, 0, 0)";>
        @if (config('adminlte.usermenu_image'))
            <img src="@if (Auth::user()->getFirstMediaUrl('user')) {{ Auth::user()->getFirstMediaUrl('user') }} @elseif(setting('img_logo')) {{ asset(setting('img_logo')) }} @else {{ asset('images/no-image.jpg') }} @endif"
                class="user-image img-circle elevation-2" alt="{{ Auth::user()->firstname }}" style="object-fit:cover;">
        @endif
        <span @if (config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ Auth::user()->firstname }} <i class="fa fa-fw fa-chevron-circle-down"></i>
        </span>
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        {{-- User menu header --}}
        @if (!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
            <li
                class="mb-3 user-header {{ config('adminlte.usermenu_header_class', 'bg-primary') }}
                @if (!config('adminlte.usermenu_image')) h-auto @endif">
                @if (config('adminlte.usermenu_image'))
                    <img src="@if (Auth::user()->getFirstMediaUrl('user')) {{ Auth::user()->getFirstMediaUrl('user') }} @elseif(setting('img_logo')) {{ asset(setting('img_logo')) }} @else {{ asset('images/no-image.jpg') }} @endif"
                        class="img-circle elevation-2" alt="{{ Auth::user()->firstname }}" style="object-fit:cover;">
                @endif
                <p class="@if (!config('adminlte.usermenu_image')) mt-0 @endif">
                    {{ Auth::user()->firstname . ' ' . Auth::user()->lastname_th }}
                    @if (config('adminlte.usermenu_desc'))
                        <small>{{ Auth::user()->username ? Auth::user()->username : '' }}</small>
                        <small>{{ (Auth::user()->site ? Auth::user()->site->name . ' / ' : '') .(Auth::user()->roles? Auth::user()->roles->pluck('description')->toArray()[0]: '') }}</small>
                    @endif
                </p>
            </li>
        @else
            @yield('usermenu_header')
        @endif

        {{-- Configured user menu links --}}
        @each('adminlte::partials.navbar.dropdown-item', $adminlte->menu('navbar-user'), 'item')

        {{-- User menu body --}}
        @hasSection('usermenu_body')
            <li class="user-body">
                @yield('usermenu_body')
            </li>
        @endif

        {{-- User menu footer --}}
        <li class="user-footer">
            @if ($profile_url)
                <a href="{{ route('user.profile', ['user' => Auth::user()->slug]) }}" class="btn btn-warning">
                    <i class="fa-solid fa-user-pen"></i>
                    โปรไฟล์
                </a>
            @endif
            <a class="btn btn-danger float-right @if (!$profile_url) btn-block @endif" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{-- <i class="fa fa-fw fa-power-off text-red"></i>
                {{ __('adminlte::adminlte.log_out') }} --}}
                <i class="fa fa-fw fa-power-off"></i>
                ออกจากระบบ
            </a>
            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @if (config('adminlte.logout_method'))
                    {{ method_field(config('adminlte.logout_method')) }}
                @endif
                {{ csrf_field() }}
            </form>
        </li>

    </ul>

</li>
