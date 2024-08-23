@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@php($password_email_url = View::getSection('password_email_url') ?? config('adminlte.password_email_url', 'password/email'))

@if (config('adminlte.use_route_url', false))
    @php($password_email_url = $password_email_url ? route($password_email_url) : '')
@else
    @php($password_email_url = $password_email_url ? url($password_email_url) : '')
@endif

@section('auth_header', __('adminlte::adminlte.password_reset_message'))

@section('auth_body')

    <div class="container p-5">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @error('email')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

        <form action="{{ $password_email_url }}" class="form" method="post">
            @csrf

            {{-- Email field --}}
            <div class="input-group mb-3" s>
                <input type="email" name="email" class="input" value="{{ old('email') }}"
                    placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
                {{-- @error('email')
                    <span class="forgot-password"><a href="#">{{ $message }}</a></span>
                    <span class="invalid-feedback text-right" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror --}}
            </div>

            {{-- Send reset link button --}}
            <button type="submit" class="btn btn-primary login-button">
                <span class="fas fa-share-square"></span>
                {{ __('adminlte::adminlte.send_password_reset_link') }}
            </button>

            <p class="mt-3 text-right">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left mr-2"></i> back to login page
                </a>
            </p>

        </form>
    </div>




@stop
