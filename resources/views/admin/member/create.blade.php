@extends('adminlte::page')
@php $pagename = 'เพิ่มข้อมูลสมาชิก'; @endphp
@section('content')
    <div class="pt-3">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('member.index') }}"
                            class="{{ env('TEXT_THEME') }}">จัดการข้อมูลสมาชิก</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('member.store') }}" method="post" enctype="multipart/form-data" id="form">
            @csrf
            <div class="card {{ env('CARD_THEME') }} card-outline">
                <div class="card-header" style="font-size: 20px;">
                    {{ $pagename }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                                {{ __('member.profile_image') }}
                                            </blockquote>
                                            <div class="text-center mt-3">
                                                <img class="rounded-circle" id="showimg"
                                                    src="https://placehold.co/300x300" width="150" height="150"
                                                    style="width: 150px; height: 150px; max-width: 100%; max-height: 100%; object-fit:cover;">
                                            </div>
                                            <div class="custom-file mb-3 mt-3">
                                                <div class="input-group">
                                                    <input name="img" type="file" class="custom-file-input"
                                                        id="imgInp">
                                                    <label class="custom-file-label"
                                                        for="imgInp">{{ __('member.add_image') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                                {{ __('member.login_information') }}
                                            </blockquote>
                                            <div class="form-group mt-3">
                                                <label for="exampleInputEmail1">{{ __('member.email') }}</label>
                                                <input type="email" class="form-control " id="email" name="email"
                                                    required>
                                                @error('email')
                                                    <div class="my-2">
                                                        <span class="{{ env('TEXT_THEME') }} my-2">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">{{ __('member.password') }}</label>
                                                <input type="password" class="form-control " id="password" name="password"
                                                    minlength="6" value="" autocomplete="new-spassword">
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    for="exampleInputPassword1">{{ __('member.password_confirmation') }}</label>
                                                <input type="password" class="form-control " id="confirmpassword"
                                                    name="confirmpassword" minlength="6" value=""
                                                    autocomplete="new-spassword">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                        {{ __('member.general_information') }}
                                    </blockquote>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-sm-6">
                                            <label>{{ __('member.first_name') }}</label>
                                            <input type="text" class="form-control " id="firstname" name="firstname"
                                                required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="inputPassword4">{{ __('member.last_name') }}</label>
                                            <input type="text" class="form-control " id="lastname" name="lastname">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>{{ __('member.phone_number') }}</label>
                                                <input type="text" class="form-control  inputmask-phone" id="phone"
                                                    name="phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                        {{ __('member.permissions') }}
                                    </blockquote>
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <th class="text-center">{{ __('member.list') }}</th>
                                            <th class="text-center" style="width: 5%;">{{ __('member.all') }}</th>
                                            <th class="text-center" style="width: 5%;">{{ __('member.view') }}</th>
                                            <th class="text-center" style="width: 5%;">{{ __('member.add') }}</th>
                                            <th class="text-center" style="width: 5%;">{{ __('member.edit') }}</th>
                                            <th class="text-center" style="width: 5%;">{{ __('member.delete') }}</th>
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
                                                                            name="permissions[]">
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
                                            <div class="card card-default mt-3">
                                                <div class="card-header">
                                                    <h3 class="card-title">{{ $key ? $key : __('member.permissions') }}
                                                    </h3>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse">
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
                                                                        name="permissions[]">
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
                        </div>

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
        $(document).ready(function() {
            $.Thailand({
                database: `{{ asset('plugins/jquery.Thailand.js/database/db.json') }}`,
                $district: $('#district'), // input ของตำบล
                $amphoe: $('#amphoe'), // input ของอำเภอ
                $province: $('#province'), // input ของจังหวัด
                $zipcode: $('#zipcode'), // input ของรหัสไปรษณีย์
            });
        });

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                showimg.src = URL.createObjectURL(file)
            }
        }

        function confirmpass() {
            var pw1 = document.forms['formsubmit']['password'].value;
            var pw2 = document.forms['formsubmit']['confirmpassword'].value;

            if (pw1 != pw2) {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: 'รหัสผ่านไม่ตรงกัน',
                });
                return false;
            } else {
                return true;
            }
        }
    </script>
@endpush
@endsection
