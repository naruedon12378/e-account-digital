@extends('adminlte::page')
@php $pagename = 'จัดการ Profile'; @endphp
@section('content')
    <div class="pt-3">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12"></div>
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <form action="{{ route('user.profile.update', ['user' => $user->id]) }}" method="post"
                    onsubmit="return confirmpass()" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card {{ env('CARD_THEME') }} card-outline">
                        <div class="card-header" style="font-size: 20px;">
                            {{ $pagename }}
                        </div>
                        <div class="card-body">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                รูปโปรไฟล์
                            </blockquote>
                            <div class="text-center mt-3">
                                <img class="rounded-circle" id="showimg"
                                    src="@if ($user->getFirstMediaUrl('user')) {{ $user->getFirstMediaUrl('user') }} @else https://placehold.co/300x300 @endif"
                                    width="150" height="150"
                                    style="width: 150px; height: 150px; max-width: 100%; max-height: 100%; object-fit:cover;">
                            </div>
                            <div class="custom-file mb-3 mt-3">
                                <div class="input-group">
                                    <input name="img" type="file" class="custom-file-input" id="imgInp">
                                    <label class="custom-file-label" for="imgInp">เพิ่มรูปภาพ</label>
                                </div>
                            </div>

                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                ข้อมูลทั่วไป
                            </blockquote>
                            <div class="row mt-3 mb-3">
                                <div class="col-sm-6">
                                    <label>ชิ่อจริง</label>
                                    <input type="text" class="form-control " id="firstname" name="firstname"
                                        value="{{ $user->firstname }}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="inputPassword4">นามสกุล</label>
                                    <input type="text" class="form-control " id="lastname" name="lastname"
                                        value="{{ $user->lastname }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>เบอร์โทรศัพท์</label>
                                        <input type="text" class="form-control  inputmask-phone" id="phone"
                                            name="phone" value="{{ $user->phone }}">
                                    </div>
                                </div>
                            </div>

                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                ข้อมูลการเข้าสู่ระบบ
                            </blockquote>
                            <div class="form-group mt-3">
                                <label for="exampleInputEmail1">อีเมล</label>
                                <input type="email" class="form-control " id="email" name="email"
                                    value="{{ $user->email }}" required readonly>
                                @error('email')
                                    <div class="my-2">
                                        <span class="{{ env('TEXT_THEME') }} my-2">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">รหัสผ่าน</label>
                                <input type="password" class="form-control " id="password" name="password" minlength="6"
                                    value="" autocomplete="new-spassword">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">ยืนยันรหัสผ่าน</label>
                                <input type="password" class="form-control " id="confirmpassword" name="confirmpassword"
                                    minlength="6" value="" autocomplete="new-spassword">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <a class='btn btn-secondary' onclick='history.back();'><i
                                        class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                                <button class='btn {{ env('BTN_THEME') }}'><i
                                        class="fas fa-save mr-2"></i>{{ __('home.save') }}</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12"></div>
        </div>

    </div>

@section('plugins.Thailand', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])
@push('js')
    <script>
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


        imgInp2.onchange = evt => {
            const [file] = imgInp2.files
            if (file) {
                showimg2.src = URL.createObjectURL(file)
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
