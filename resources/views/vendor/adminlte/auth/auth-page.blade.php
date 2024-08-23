@extends('adminlte::master')

@php($dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home'))

@if (config('adminlte.use_route_url', false))
    @php($dashboard_url = $dashboard_url ? route($dashboard_url) : '')
@else
    @php($dashboard_url = $dashboard_url ? url($dashboard_url) : '')
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $('.js-tilt').tilt({
                scale: 1.2
            })
        </script>
    @endpush

    <div class="card text-center" style="width:65%; height: 65%;">
        <div class="card-body"
            style="width: 100%; height: 100%; margin: 0 auto; display: flex; align-items:center; justify-content: center;">
            <div class="row" style="width: 100%; display: flex; align-items:center; justify-content: center;">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <img class="js-tilt mb-3" src="{{ asset(setting('img_logo')) }}" style="width: 40%">
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    @yield('auth_header')
                    @yield('auth_body')
                </div>
            </div>
        </div>

    </div>
    {{-- <div class="{{ $auth_type ?? 'login' }}-box"> --}}



    {{-- Login Form --}}
    {{-- <div class="container"> --}}
    {{-- Logo --}}

    {{-- <div class="text-center"> --}}
    {{-- <img class="mb-3" src="{{ asset(setting('img_logo')) }}" height="150"> --}}
    {{-- <h4 class="text-center mb-3">{{ setting('title_th') }}</h4> --}}
    {{-- </div> --}}
    {{-- <div class="heading">@yield('auth_header')</div> --}}
    {{-- @yield('auth_body') --}}
    {{-- </div> --}}

    {{-- Card Box --}}
    {{-- <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}"> --}}

    {{-- Card Header --}}
    {{-- @hasSection('auth_header')
                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none text-center">
                        @yield('auth_header')
                    </h3>
                </div>
            @endif --}}

    {{-- Card Body --}}
    {{-- <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                @yield('auth_body')
            </div> --}}



    {{-- Card Footer --}}
    {{-- @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                    @yield('auth_footer')
                </div>
            @endif --}}

    {{-- </div> --}}

    {{-- </div> --}}
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop

<style>
    .form {
        margin-top: 20px;
    }

    .form .input {
        width: 100%;
        background: white;
        border: none;
        padding: 15px 20px;
        border-radius: 20px;
        margin-top: 15px;
        /* box-shadow: #ffefef 0px 10px 10px -5px; */
        box-shadow: #cff0ff 0px 10px 10px -5px;
        border-inline: 2px solid transparent;
    }

    .form .input::-moz-placeholder {
        color: rgb(170, 170, 170);
    }

    .form .input::placeholder {
        color: rgb(170, 170, 170);
    }

    .form .input:focus {
        outline: none;
        border-inline: 2px solid #12B1D1;
        /* border-inline: 2px solid #C70000; */
    }

    .form .forgot-password {
        display: block;
        margin-top: 10px;
        margin-left: 10px;
    }

    .form .forgot-password a {
        font-size: 13px;
        color: #12B1D1;
        text-decoration: none;
    }

    .form .login-button {
        display: block;
        width: 100%;
        font-weight: bold;
        /* background: linear-gradient(45deg, #C70000 0%, #ff5151 100%); */
        background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
        color: white;
        padding-block: 15px;
        margin: 20px auto;
        border-radius: 20px;
        box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
        /* box-shadow: rgba(199, 0, 0, 0.878) 0px 20px 10px -15px; */
        border: none;
        transition: all 0.2s ease-in-out;
    }

    .form .login-button:hover {
        transform: scale(1.03);
        box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
        /* box-shadow: rgba(199, 0, 0, 0.878) 0px 23px 10px -20px; */
    }

    .form .login-button:active {
        transform: scale(0.95);
        box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
        /* box-shadow: rgba(199, 0, 0, 0.878) 0px 15px 10px -10px; */
    }

    .card.text-center {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
