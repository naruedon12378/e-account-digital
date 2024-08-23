@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
@php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
    @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
    @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
@endif

@section('auth_header', setting('title_th'))

@section('auth_body')
    <div class="container">
        <div class="row" style="width: 100%;display: flex; align-items:center; justify-content: center;">
            <form action="{{ $login_url }}" class="form" method="post">
                @csrf
                <input class="input" type="text" name="username" placeholder="Email" value="{{ old('username') }}"
                    autofocus required>
                <input class="input" type="password" name="password" id="password" placeholder="Password" required>

                {{-- Password reset link --}}
                @if ($password_reset_url)
                    <p class="mt-3 text-right forgot-password">
                        <a href="{{ $password_reset_url }}">
                            {{ __('adminlte::adminlte.i_forgot_my_password') }}
                        </a>
                    </p>
                @endif

                @if (session('message_wrong'))
                    <span class="forgot-password"><a href="#">{{ session('message_wrong') }}</a></span>
                @endif
                @if (session('message_status'))
                    <span class="forgot-password"><a href="#">{{ session('message_status') }}</a></span>
                @endif

                {{-- <span class="forgot-password"><a href="#">Forgot Password ?</a></span> --}}
                <button class="btn btn-primary login-button" type="submit"><i
                        class="fas fa-sign-in-alt mr-3"></i>เข้าสู่ระบบ</button>



                {{-- Register link --}}
                @if ($register_url)
                    <p class="my-0">
                        <a href="{{ $register_url }}">
                            {{ __('adminlte::adminlte.register_a_new_membership') }}
                        </a>
                    </p>
                @endif
            </form>
        </div>

    </div>


@stop
