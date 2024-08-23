@extends('adminlte::page')
@php
    $pagename = __('payroll_employee.view');
    $locale = app()->getlocale();
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

        <form method="post"
            action="{{ route('payroll_employee.update', ['payroll_employee' => $payroll_employee['id']]) }}"
            enctype="multipart/form-data" id="form">
            @method('PUT')
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $payroll_employee['id'] }}">
            <div class="card {{ env('CARD_THEME') }} card-outline shadow-custom">
                <div class="card-header">
                    <span style="font-size: 20px;">{{ $pagename }}</span>
                    <div class="ml-3 float-right">
                        <div class="icheck-primary icheck-inline">
                            <input type="radio" name="type_form" id="basic_form" value="basic"
                                {{ @$payroll_employee['type_form'] == 'basic' ? 'checked' : '' }} />
                            <label for="basic_form">{{ __('payroll_employee.basic') }}</label>
                        </div>
                        <div class="icheck-primary icheck-inline">
                            <input type="radio" name="type_form" id="advance_form" value="advance"
                                {{ @$payroll_employee['type_form'] == 'advance' ? 'checked' : '' }} />
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
                                        @php
                                            if ($payroll_employee->getFirstMediaUrl('employee_profile')) {
                                                $profile = asset(
                                                    $payroll_employee->getFirstMediaUrl('employee_profile'),
                                                );
                                                $profile_text = basename(
                                                    $payroll_employee->getFirstMedia('employee_profile')->getPath(),
                                                );
                                            } else {
                                                $profile = asset('images/no-image.jpg');
                                                $profile_text = __('payroll_employee.add_image');
                                            }
                                        @endphp
                                        <img class="rounded-circle" id="showimg" src="{{ $profile }}"
                                            alt="User profile picture" width="150" height="150"
                                            style="max-width: 100%; max-height: 100%;">
                                    </div>
                                    <div class="custom-file mb-3 mt-3">
                                        <div class="input-group">
                                            <label class="custom-file-label" for="imgInp">{{ $profile_text }}</label>
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
                                        <input type="email" class="form-control " id="email" name="email"
                                            value="{{ @$payroll_employee['email'] }}">
                                        @error('email')
                                            <span class="text-danger">** {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('payroll_employee.phone_number') }}</label>
                                        <input type="text" class="form-control  inputmask-phone" name="phone"
                                            id="phone" value="{{ @$payroll_employee['phone'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('payroll_employee.emer_contact') }}</label>
                                        <input type="text" class="form-control " name="urgent_name" id="urgent_name"
                                            value="{{ @$payroll_employee['urgent_name'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('payroll_employee.emer_number') }}</label>
                                        <input type="text" class="form-control  inputmask-phone" name="urgent_phone"
                                            id="urgent_phone" value="{{ @$payroll_employee['urgent_phone'] }}" required>
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
                                        {{ __('payroll_employee.address_info') }}
                                    </blockquote>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-sm-12">
                                            <label>{{ __('payroll_employee.address') }}</label>
                                            <textarea id="address" name="address" class="form-control" rows="3">{{ @$payroll_employee['address'] }}</textarea>
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.sub_district') }}</label>
                                            <input class="form-control " name="sub_district" id="sub_district"
                                                value="{{ @$payroll_employee['sub_district'] }}">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.district') }}</label>
                                            <input class="form-control " name="district" id="district"
                                                value="{{ @$payroll_employee['district'] }}">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.province') }}</label>
                                            <input class="form-control " name="province" id="province"
                                                value="{{ @$payroll_employee['province'] }}">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.postal_code') }}</label>
                                            <input type="text" class="form-control  " name="zipcode" id="zipcode"
                                                value="{{ @$payroll_employee['zipcode'] }}">
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
                                                value="{{ @$payroll_employee['citizen_no'] }}" required>
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            @php
                                                if ($payroll_employee->getFirstMediaUrl('employee_ctz')) {
                                                    $ctz_text = basename(
                                                        $payroll_employee->getFirstMedia('employee_ctz')->getPath(),
                                                    );
                                                } else {
                                                    $ctz_text = __('payroll_employee.upload_file');
                                                }
                                            @endphp
                                            <div class="custom-file">
                                                <label>{{ __('payroll_employee.upload_id_card_file') }}</label>
                                                <div class="input-group input-group-sm">
                                                    <label class="custom-file-label"
                                                        for="img_citizen">{{ $ctz_text }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            @php
                                                if (isset($payroll_employee['start_date'])) {
                                                    $dateval = DateTime::createFromFormat(
                                                        'Y-m-d',
                                                        $payroll_employee['start_date'],
                                                    )->format('dmY');
                                                }
                                            @endphp
                                            <label>{{ __('payroll_employee.start_date') }}</label>
                                            <input type="text" class="form-control  inputmask-date datepicker"
                                                id="start_date" name="start_date" value="{{ @$dateval }}" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">{{ __('payroll_employee.prefix') }}</label>
                                            <select class="form-control " name="prefix_id" id="prefix_id">
                                                @foreach ($prefixes as $prefix)
                                                    <option value="{{ $prefix->id }}"
                                                        {{ isset($payroll_employee['prefix_id']) ? ($payroll_employee['prefix_id'] == $prefix->id ? 'selected' : '') : '' }}>
                                                        {{ $prefix->name_th }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4"></div>
                                        <div class="mb-3 col-sm-4">
                                            <label>{{ __('payroll_employee.first_name_th') }} </label> <label
                                                class="text-danger">*</label>
                                            <input type="text" class="form-control " id="first_name_th"
                                                name="first_name_th" value="{{ @$payroll_employee['first_name_th'] }}"
                                                required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label>{{ __('payroll_employee.middle_name_th') }}</label>
                                            <input type="text" class="form-control " id="middle_name_th"
                                                name="middle_name_th" value="{{ @$payroll_employee['middle_name_th'] }}">
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="inputPassword4">{{ __('payroll_employee.last_name_th') }}</label>
                                            <label class="text-danger">*</label>
                                            <input type="text" class="form-control " id="last_name_th"
                                                name="last_name_th" value="{{ @$payroll_employee['last_name_th'] }}"
                                                required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label>{{ __('payroll_employee.first_name_en') }}</label>
                                            <label class="text-danger">*</label>
                                            <input type="text" class="form-control " id="first_name_en"
                                                name="first_name_en" value="{{ @$payroll_employee['first_name_en'] }}"
                                                required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label>{{ __('payroll_employee.middle_name_en') }}</label>
                                            <input type="text" class="form-control " id="middle_name_en"
                                                name="middle_name_en" value="{{ @$payroll_employee['middle_name_en'] }}">
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="inputPassword4">{{ __('payroll_employee.last_name_en') }}</label>
                                            <label class="text-danger">*</label>
                                            <input type="text" class="form-control " id="last_name_en"
                                                name="last_name_en" value="{{ @$payroll_employee['last_name_en'] }}"
                                                required>
                                        </div>

                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">{{ __('payroll_employee.department') }}</label>
                                            <select class="form-control " name="department_id" id="department_id"
                                                style="width: 100%">
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ isset($payroll_employee['department_id']) ? ($payroll_employee['department_id'] == $department->id ? 'selected' : '') : '' }}>
                                                        @if ($locale == 'th')
                                                            {{ $department->name_th }}
                                                        @else
                                                            {{ $department->name_en }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">{{ __('payroll_employee.contract_type') }}</label>
                                            <select class="form-control " name="contract_type" id="contract_type"
                                                style="width: 100%">
                                                <option value="1"
                                                    {{ isset($payroll_employee['contract_type']) ? ($payroll_employee['contract_type'] == 1 ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.monthly') }} </option>
                                                <option value="2"
                                                    {{ isset($payroll_employee['contract_type']) ? ($payroll_employee['contract_type'] == 2 ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.daily') }} </option>
                                            </select>
                                        </div>

                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">{{ __('payroll_employee.position') }}</label>
                                            <input type="text" class="form-control " id="position" name="position"
                                                value="{{ @$payroll_employee['position'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card advance_form " style="display: none;">
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
                                            <input type="text" class="form-control  " name="salary" id="salary"
                                                value="{{ @$payroll_employee['salary'] }}">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label>{{ __('payroll_employee.adjust_salary_account_code') }}</label>
                                            <select name="account_id" id="account_id" class="form-control select2"
                                                style="width:100%">
                                                <option value="">{{ __('payroll_employee.not_specified') }}</option>
                                                @foreach ($account_types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ isset($payroll_employee['account_id']) ? ($payroll_employee['account_id'] == $type->id ? 'selected' : '') : '' }}>
                                                        @if ($locale == 'th')
                                                            {{ $type->name_th }}
                                                        @else
                                                            {{ $type->name_en }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-lg-4 col-md-12 col-sm-12">
                                            <label>{{ __('payroll_employee.social_security') }}</label>
                                            <div class="icheck-primary">
                                                <input type="checkbox" name="scc_chkbox" id="scc_chkbox" value="1"
                                                    {{ isset($payroll_employee['scc_chkbox']) ? ($payroll_employee['scc_chkbox'] == 1 ? 'checked' : '') : '' }} />
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
                                                            id="tax_holding_chkbox" value="1"
                                                            {{ isset($payroll_employee['tax_holding_chkbox']) ? ($payroll_employee['tax_holding_chkbox'] == 1 ? 'checked' : '') : '' }} />
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
                                                        id="tax_holding"
                                                        value="{{ @$payroll_employee['tax_holding'] }}" />
                                                </div>
                                            </div>
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
                                                <option value="bank"
                                                    {{ isset($payroll_employee['payment_channel']) ? ($payroll_employee['payment_channel'] == 'bank' ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.bank') }}</option>
                                                <option value="promptpay"
                                                    {{ isset($payroll_employee['payment_channel']) ? ($payroll_employee['payment_channel'] == 'promptpay' ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.promptpay') }}</option>
                                                <option value="cash"
                                                    {{ isset($payroll_employee['payment_channel']) ? ($payroll_employee['payment_channel'] == 'cash' ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.cash') }}</option>
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
                                                    <option value="{{ $bank->id }}"
                                                        {{ isset($payroll_employee['payment_channel']) ? ($payroll_employee['payment_channel'] == $bank->id ? 'selected' : '') : '' }}>
                                                        {{ $bank->name_th }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-6 advance_form bank_form" style="display: none;">
                                            <label>{{ __('payroll_employee.account_type') }}</label>
                                            <select name="account_type" id="account_type" class="form-control select2"
                                                style="width:100%;">
                                                <option value="2"
                                                    {{ isset($payroll_employee['account_type']) ? ($payroll_employee['account_type'] == 2 ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.saving_account') }}
                                                </option>
                                                <option value="1"
                                                    {{ isset($payroll_employee['account_type']) ? ($payroll_employee['account_type'] == 1 ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.current_account') }}
                                                </option>
                                                <option value="3"
                                                    {{ isset($payroll_employee['account_type']) ? ($payroll_employee['account_type'] == 3 ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.fixed_deposit_account') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-6 advance_form bank_form" style="display: none;">
                                            <label>{{ __('payroll_employee.account_name') }}</label>
                                            <input type="text" class="form-control " name="account_name"
                                                id="account_name" value="{{ @$payroll_employee['account_name'] }}">
                                        </div>
                                        <div class="mb-3 col-sm-6 bank_form">
                                            <label>{{ __('payroll_employee.account_number') }}</label>
                                            <input type="text" class="form-control " name="account_number"
                                                id="account_number" value="{{ @$payroll_employee['account_number'] }}">
                                        </div>
                                        <div class="mb-3 col-sm-6 advance_form bank_form" style="display: none;">
                                            <label>{{ __('payroll_employee.branch_name') }}</label>
                                            <input type="text" class="form-control " name="branch_name"
                                                id="branch_name" value="{{ @$payroll_employee['branch_name'] }}">
                                        </div>
                                        <div class="mb-3 col-sm-6 advance_form bank_form" style="display: none;">
                                            <label>{{ __('payroll_employee.branch_number') }}</label>
                                            <input type="text" class="form-control  " name="branch_code"
                                                id="branch_code" value="{{ @$payroll_employee['branch_code'] }}">
                                        </div>

                                        <div class="mb-3 col-sm-6 promptpay_form" style="display: none;">
                                            <label>{{ __('payroll_employee.promptpay_type') }}</label>
                                            <select name="promptpay_type" id="promptpay_type"
                                                class="form-control select2" style="width:100%;">
                                                <option value="mobile_number"
                                                    {{ isset($payroll_employee['promptpay_type']) ? ($payroll_employee['promptpay_type'] == 'mobile_number' ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.mobile_number') }}
                                                </option>
                                                <option value="citizen_id_number"
                                                    {{ isset($payroll_employee['promptpay_type']) ? ($payroll_employee['promptpay_type'] == 'citizen_id_number' ? 'selected' : '') : '' }}>
                                                    {{ __('payroll_employee.citizen_number') }}</option>
                                            </select>
                                        </div>

                                        <div class="mb-3 col-sm-6 promptpay_form" style="display: none;">
                                            <label>{{ __('payroll_employee.promptpay_number') }}</label>
                                            <input type="text" class="form-control  " name="promptpay_number"
                                                id="promptpay_number"
                                                value="{{ @$payroll_employee['promptpay_number'] }}">
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

            chkFormType();
            chkPaymentType("{{ $payroll_employee['payment_channel'] }}")

            $('input').prop('readonly', true)
            $('textarea').prop('readonly', true)
            $('select').prop('disabled', true)
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



        function chkPaymentType(value) {
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
        }

        $('#payment_channel').on('change', function() {
            value = $(this).val();
            chkPaymentType(value)
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
