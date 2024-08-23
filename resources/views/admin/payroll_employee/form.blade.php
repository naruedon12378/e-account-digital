@extends('adminlte::page')
@php
    $pagename = __('payroll_employee.add');
    $locale = app()->getlocale();
    $name = 'name_' . $locale;
@endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="contrainer p-2">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> {{ __('home.homepage') }}</a></li>
                    <li class="breadcrumb-item"><a href="#" onclick="history.back()"
                            class="{{ env('TEXT_THEME') }}">{{ __('payroll_employee.head') }}</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>

        <form method="post" action="{{ route('payroll_employee.store') }}" enctype="multipart/form-data" id="form">
            @csrf
            <div class="card {{ env('CARD_THEME') }} card-outline shadow-custom">
                <div class="card-header">
                    <span style="font-size: 20px;">{{ $pagename }}</span>
                    <div class="ml-3 float-right">
                        <div class="icheck-primary icheck-inline">
                            <input type="radio" name="type_form" id="basic_form" value="basic" checked />
                            <label for="basic_form">{{ __('payroll_employee.basic') }}</label>
                        </div>
                        <div class="icheck-primary icheck-inline">
                            <input type="radio" name="type_form" id="advance_form" value="advance" />
                            <label for="advance_form">{{ __('payroll_employee.advance') }}</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="rounded-circle" id="showimg" src="{{ asset('images/no-image.jpg') }}"
                                            alt="User profile picture" width="150" height="150"
                                            style="max-width: 100%; max-height: 100%;">
                                    </div>
                                    <div class="custom-file mb-3 mt-3">
                                        <div class="input-group">
                                            <input name="img" type="file" class="custom-file-input" id="imgInp">
                                            <label class="custom-file-label"
                                                for="imgInp">{{ __('payroll_employee.add_image') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" style="border-bottom: none;">
                                    <button type="button" class="btn btn-tool float-right mt-1"
                                        data-card-widget="collapse">
                                        {{ __('payroll_employee.show_less') }}
                                    </button>
                                    <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                        {{ __('payroll_employee.contact_info') }}
                                    </blockquote>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('payroll_employee.email') }}</label>
                                        <label class="text-danger"></label>
                                        <input type="email" class="form-control " id="email" name="email">
                                        @error('email')
                                            <span class="text-danger">** {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('payroll_employee.phone_number') }}</label>
                                        <input type="text" class="form-control  inputmask-phone" name="phone"
                                            id="phone" required>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('payroll_employee.emer_contact') }}</label>
                                        <input type="text" class="form-control " name="urgent_name" id="urgent_name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('payroll_employee.emer_number') }}</label>
                                        <input type="text" class="form-control  inputmask-phone" name="urgent_phone"
                                            id="urgent_phone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card collapsed-card">
                                <div class="card-header" style="border-bottom: none;">
                                    <button type="button" class="btn btn-tool float-right mt-1"
                                        data-card-widget="collapse">
                                        {{ __('payroll_employee.show_less') }}
                                    </button>
                                    <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                        {{ __('payroll_employee.address_info') }}
                                    </blockquote>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-sm-12">
                                            <label>{{ __('payroll_employee.address') }}</label>
                                            <textarea id="address" name="address" class="form-control" rows="3"></textarea>
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.sub_district') }}</label>
                                            <input class="form-control " name="sub_district" id="sub_district">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.district') }}</label>
                                            <input class="form-control " name="district" id="district">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.province') }}</label>
                                            <input class="form-control " name="province" id="province">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.postal_code') }}</label>
                                            <input type="text" class="form-control  " name="zipcode" id="zipcode">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-9">
                            <div class="card">
                                <div class="card-header" style="border-bottom: none;">
                                    <button type="button" class="btn btn-tool float-right mt-1"
                                        data-card-widget="collapse">
                                        {{ __('payroll_employee.show_less') }}
                                    </button>
                                    <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                        {{ __('payroll_employee.general_info') }}
                                    </blockquote>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.citizen_number') }}</label>
                                            <input type="text" class="form-control" id="citizen_no" name="citizen_no"
                                                required>
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <div class="custom-file">
                                                <label>{{ __('payroll_employee.upload_id_card_file') }}</label>
                                                <div class="input-group input-group-sm">
                                                    <input name="img_citizen" type="file"
                                                        class="custom-file-input   id=" img_citizen"
                                                        onchange="updateFileLabel()">
                                                    <label class="custom-file-label"
                                                        for="img_citizen">{{ __('payroll_employee.upload_file') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label>{{ __('payroll_employee.start_date') }}</label>
                                            <input type="text" class="form-control  inputmask-date datepicker"
                                                id="start_date" name="start_date" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">{{ __('payroll_employee.prefix') }}</label>
                                            <select class="form-control " name="prefix_id" id="prefix_id">
                                                @foreach ($prefixes as $prefix)
                                                    <option value="{{ $prefix->id }}">{{ $prefix->$name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4"></div>
                                        <div class="mb-3 col-sm-4">
                                            <label>{{ __('payroll_employee.first_name_th') }} </label> <label
                                                class="text-danger">*</label>
                                            <input type="text" class="form-control " id="first_name_th"
                                                name="first_name_th" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label>{{ __('payroll_employee.middle_name_th') }}</label>
                                            <input type="text" class="form-control " id="middle_name_th"
                                                name="middle_name_th">
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="inputPassword4">{{ __('payroll_employee.last_name_th') }}</label>
                                            <label class="text-danger">*</label>
                                            <input type="text" class="form-control " id="last_name_th"
                                                name="last_name_th" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label>{{ __('payroll_employee.first_name_en') }}</label>
                                            <input type="text" class="form-control " id="first_name_en"
                                                name="first_name_en" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label>{{ __('payroll_employee.middle_name_en') }}</label>
                                            <input type="text" class="form-control " id="middle_name_en"
                                                name="middle_name_en">
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="inputPassword4">{{ __('payroll_employee.last_name_en') }}</label>
                                            <input type="text" class="form-control " id="last_name_en"
                                                name="last_name_en" required>
                                        </div>

                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">{{ __('payroll_employee.department') }}</label>
                                            <select class="form-control " name="department_id" id="department_id"
                                                style="width: 100%">
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->$name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">{{ __('payroll_employee.contract_type') }}</label>
                                            <select class="form-control " name="contract_type" id="contract_type"
                                                style="width: 100%">
                                                <option value="1">{{ __('payroll_employee.monthly') }}</option>
                                                <option value="2">{{ __('payroll_employee.daily') }}</option>
                                            </select>
                                        </div>

                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">{{ __('payroll_employee.position') }}</label>
                                            <input type="text" class="form-control " id="position" name="position">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card advance_form collapsed-card" style="display: none;">
                                <div class="card-header" style="border-bottom: none;">
                                    <button type="button" class="btn btn-tool float-right mt-1"
                                        data-card-widget="collapse">
                                        {{ __('payroll_employee.show_less') }}
                                    </button>
                                    <blockquote class="quote-success text-md " style="margin: 0 !important;">
                                        {{ __('payroll_employee.salary_info') }}
                                    </blockquote>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.default_salary_amount') }}</label>
                                            <input type="text" class="form-control  " name="salary" id="salary">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.adjust_salary_account_code') }}</label>
                                            <select name="account_id" id="account_id" class="form-control select2"
                                                style="width:100%">
                                                <option value="">{{ __('payroll_employee.not_specified') }}</option>
                                                @foreach ($account_types as $type)
                                                    <option value="{{ $type->id }}">
                                                        {{ $type->$name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-lg-4 col-md-12 col-sm-12">
                                            <label>{{ __('payroll_employee.social_security') }}</label>
                                            <div class="icheck-primary">
                                                <input type="checkbox" name="scc_chkbox" id="scc_chkbox" value="1"
                                                    checked />
                                                <label
                                                    for="scc_chkbox">{{ __('payroll_employee.registered_social_security') }}</label>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-lg-8 col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="mb-3 col-lg-3 col-md-4 col-sm-12">
                                                    <label>{{ __('payroll_employee.withholding_tax') }}</label>
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" name="tax_holding_chkbox"
                                                            id="tax_holding_chkbox" value="1" checked />
                                                        <label
                                                            for="tax_holding_chkbox">{{ __('payroll_employee.withholding_tax') }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-lg-2 col-md-4 col-sm-12">
                                                    <label>{{ __('payroll_employee.wht') }}</label>
                                                    <select name="pnd_type" id="pnd_type" class="form-control select2"
                                                        style="width:100%" disabled>
                                                        <option value="1">{{ __('payroll_employee.pnd_type_1') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-lg-7 col-md-4 col-sm-12">
                                                    <label>{{ __('payroll_employee.default_withholding_tax_amount') }}</label>
                                                    <input type="text" class="form-control " name="tax_holding"
                                                        id="tax_holding" />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="card collapsed-card">
                                <div class="card-header" style="border-bottom: none;">
                                    <button type="button" class="btn btn-tool float-right mt-1"
                                        data-card-widget="collapse">
                                        {{ __('payroll_employee.show_less') }}
                                    </button>
                                    <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                        {{ __('payroll_employee.payment_channel_info') }}
                                    </blockquote>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 mb-3 advance_form" style="display: none;">
                                            <label>{{ __('payroll_employee.payment_channel_info') }}
                                            </label>
                                            <select name="payment_channel" id="payment_channel"
                                                class="form-control select2" style="width:100%;">
                                                <option value="bank">{{ __('payroll_employee.bank') }}</option>
                                                <option value="promptpay">{{ __('payroll_employee.promptpay') }}</option>
                                                <option value="cash">{{ __('payroll_employee.cash') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <hr class="line" style="display: none;" />
                                        </div>
                                        <div class="mb-3 col-sm-6 bank_form">
                                            <label>{{ __('payroll_employee.bank') }}</label>
                                            <select name="bank_id" id="bank_id" class="form-control select2"
                                                style="width:100%">
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->$name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-6 advance_form bank_form" style="display: none;">
                                            <label>{{ __('payroll_employee.account_type') }}</label>
                                            <select name="account_type" id="account_type" class="form-control select2"
                                                style="width:100%;">
                                                <option value="">{{ __('payroll_employee.saving_account') }}
                                                </option>
                                                <option value="">{{ __('payroll_employee.current_account') }}
                                                </option>
                                                <option value="">{{ __('payroll_employee.fixed_deposit_account') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-6 advance_form bank_form" style="display: none;">
                                            <label>{{ __('payroll_employee.account_name') }}</label>
                                            <input type="text" class="form-control " name="account_name"
                                                id="account_name">
                                        </div>
                                        <div class="mb-3 col-sm-6 bank_form">
                                            <label>{{ __('payroll_employee.account_number') }}</label>
                                            <input type="text" class="form-control " name="account_number"
                                                id="account_number">
                                        </div>
                                        <div class="mb-3 col-sm-6 advance_form bank_form" style="display: none;">
                                            <label>{{ __('payroll_employee.branch_name') }}</label>
                                            <input type="text" class="form-control " name="branch_name"
                                                id="branch_name">
                                        </div>
                                        <div class="mb-3 col-sm-6 advance_form bank_form" style="display: none;">
                                            <label>{{ __('payroll_employee.branch_number') }}</label>
                                            <input type="text" class="form-control  " name="branch_code"
                                                id="branch_code">
                                        </div>

                                        <div class="mb-3 col-sm-6 promptpay_form" style="display: none;">
                                            <label>{{ __('payroll_employee.promptpay_type') }}</label>
                                            <select name="promptpay_type" id="promptpay_type"
                                                class="form-control select2" style="width:100%;">
                                                <option value="mobile_number">{{ __('payroll_employee.mobile_number') }}
                                                </option>
                                                <option value="citizen_id_number" selected>
                                                    {{ __('payroll_employee.citizen_number') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-3 col-sm-6 promptpay_form" style="display: none;">
                                            <label>{{ __('payroll_employee.promptpay_number') }}</label>
                                            <input type="text" class="form-control  " name="promptpay_number"
                                                id="promptpay_number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="float-right">
                        <a class="btn btn-secondary" href="{{ route('payroll_employee.index') }}"><i
                                class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                        <button class="btn {{ env('BTN_THEME') }}" type="submit"><i
                                class="fas fa-save mr-2"></i>{{ __('home.save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@section('plugins.Thailand', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])
@push('js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script> --}}
    <script>
        $(document).ready(function() {
            $.Thailand({
                database: `{{ asset('plugins/jquery.Thailand.js/database/db.json') }}`,
                $district: $('#sub_district'), // input ของตำบล
                $amphoe: $('#district'), // input ของอำเภอ
                $province: $('#province'), // input ของจังหวัด
                $zipcode: $('#zipcode'), // input ของรหัสไปรษณีย์
            });
        });

        $('#form').submit(function() {
            if ($('#first_name_th').val() == null || $('#first_name_th').val() == "") {
                toastr.error('กรุณาใส่ชื่อหัวข้อภาษาไทย');
                return false;
            }

            if ($('#first_name_en').val() == null || $('#first_name_en').val() == "") {
                toastr.error('กรุณาใส่ชื่อหัวข้อภาษาอังกฤษ');
                return false;
            }
        });

        $("input[name='type_form']").on('change', function() {
            chkFormType();
        });

        function chkFormType() {
            type = $("input[name='type_form']:checked").val();
            if (type == 'advance') {
                $('.advance_form').css('display', '');
            } else {
                $('.advance_form').css('display', 'none');
            }
        }

        $('#payment_channel').on('change', function() {
            console.log($(this).val());
            value = $(this).val();
            if (value == 'promptpay') {
                $('.bank_form').css('display', 'none');
                $('.promptpay_form').css('display', '');
                $('.line').css('display', '');
            } else if (value == 'bank') {
                $('.bank_form').css('display', '');
                $('.promptpay_form').css('display', 'none');
                $('.line').css('display', '');
            } else {
                $('.bank_form').css('display', 'none');
                $('.promptpay_form').css('display', 'none');
                $('.line').css('display', 'none');
            }
        });

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                showimg.src = URL.createObjectURL(file)
            }
        }
    </script>
@endpush
@endsection
