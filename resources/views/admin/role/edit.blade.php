@extends('adminlte::page')
@php $pagename = 'แก้ไขบทบาท'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="pt-3">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('role.index') }}"
                            class="{{ env('TEXT_THEME') }}">จัดการบทบาท</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('role.update', ['role' => $role->id]) }}" method="post" enctype="multipart/form-data"
            id="form">
            @method('PUT')
            @csrf
            <div class="card {{ env('CARD_THEME') }} card-outline">
                <div class="card-header" style="font-size: 20px;">
                    {{ $pagename }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('role.role') }}</label>
                        <input class="form-control " name="name" id="name" value="{{ $role->name }}"
                            {{ in_array($role->name, ['developer', 'superadmin', 'admin', 'user']) ? 'readonly' : '' }} />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('role.description') }}</label>
                        <input class="form-control " name="description" id="description"
                            value="{{ $role->description }}" />
                    </div>
                    <div class="mb-3">

                        <label class="form-label">{{ __('role.permissions') }}</label>

                        <table class="table table-bordered">
                            <thead>
                                <th class="text-center">{{ __('role.list') }}</th>
                                <th class="text-center" style="width: 5%;">{{ __('role.all') }}</th>
                                <th class="text-center" style="width: 5%;">{{ __('role.view') }}</th>
                                <th class="text-center" style="width: 5%;">{{ __('role.add') }}</th>
                                <th class="text-center" style="width: 5%;">{{ __('role.edit') }}</th>
                                <th class="text-center" style="width: 5%;">{{ __('role.delete') }}</th>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($permissions as $key => $group_permission)
                                        @if ($key)
                                            <td>{{ $key ? (app()->isLocale('en') ? str_replace('_', ' ', ucwords($key)) . ' Management' : 'จัดการ' . ucwords($key)) : 'อื่นๆ' }}
                                            </td>
                                            @foreach ($group_permission as $permission)
                                                @if ($permission->group_en == $key || $permission->group_th == $key)
                                                    <td style="width: 5%;">
                                                        <label class="switch2 mr-2"> <input type="checkbox"
                                                                value="{{ $permission->id }}" id=""
                                                                name="permissions[]"
                                                                {{ in_array($permission->name, $role->getPermissionNames()->toArray()) ? 'checked' : '' }}>
                                                            <span class="slider2"></span>
                                                        </label>
                                                    </td>
                                                @endif
                                            @endforeach
                                        @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach ($permissions as $key => $group_permission)
                            @if (!$key)
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $key ? $key : __('role.other') }}</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($group_permission as $permission)
                                            @if ($permission->group_en == $key || $permission->group_th == $key)
                                                <div>
                                                    <label class="switch2 mr-2"> <input type="checkbox"
                                                            value="{{ $permission->id }}" id=""
                                                            name="permissions[]"
                                                            {{ in_array($permission->name, $role->getPermissionNames()->toArray()) ? 'checked' : '' }}>
                                                        <span class="slider2 "></span>
                                                    </label>
                                                    <span
                                                        class="">{{ app()->isLocale('en') ? str_replace('_', ' ', ucwords($permission->name)) : $permission->description }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a class='btn btn-secondary' onclick='history.back();'><i
                                class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                        <a class='btn {{ env('BTN_THEME') }}' onclick="submitData()"><i
                                class="fas fa-save mr-2"></i>{{ __('home.save') }}</a>
                    </div>
                </div>
            </div>
        </form>


    </div>

@section('plugins.Thailand', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])
@push('js')
    <script>
        function submitData() {
            Swal.fire({
                title: '{{ __('home.alert_confirm_text') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: '{{ __('home.close') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form').submit();
                }
            })
        }
    </script>
@endpush
@endsection
