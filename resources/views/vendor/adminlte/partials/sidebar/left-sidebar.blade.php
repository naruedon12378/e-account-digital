<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if (config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if (config('adminlte.sidebar_nav_animation_speed') != 300) data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}" @endif
                @if (!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>

                {{-- Profiles --}}
                {{-- <div class="row mt-2 mb-2 ml-2">
                    @if (config('adminlte.usermenu_image'))
                        <div class="col-lg-3 col-md-3 d-none d-sm-block">
                            <img src="@if (Auth::user()->getFirstMediaUrl('user')) {{ Auth::user()->getFirstMediaUrl('user') }} @elseif(setting('logo')) {{ asset(setting('logo')) }} @else {{ asset('images/no-image.jpg') }} @endif" class="img-circle elevation-2 mb-2" style="width: 100%; height: 50px; object-fit:cover;">
                        </div>
                    @endif
                    <div class="col-lg-9 col-md-9 col-sm-12 text-lg-left text-md-left text-sm-center">
                            {{ Auth::user()->username }}
                        <div class="brand-text font-weight-bold {{ config('adminlte.classes_brand_text') }} @if (!config('adminlte.usermenu_image')) @endif">
                            {{ Auth::user()->f_name }} {{ Auth::user()->l_name }}
                        </div>
                        <div class="brand-text font-weight-light {{ config('adminlte.classes_brand_text') }} @if (!config('adminlte.usermenu_image')) @endif">
                            {{ Auth::user()->roles()->get()[0]->description; }}
                        </div>
                    </div>
                </div> --}}
                {{-- <li class="nav-header">
                        ข้อมูล Session
                    </li> --}}
                {{-- @if (session('session'))
                        <div class="row mb-2 ml-2 mr-2">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <b>บริษัท</b> : {{ session('session')[0]['company_name'] }} <br/>
                                        <b>แบรนด์</b> : {{ session('session')[0]['brand_name'] }} <br/>
                                        <b>สาขา</b> : {{ session('session')[0]['branch_name'] }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif --}}

                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>

</aside>
