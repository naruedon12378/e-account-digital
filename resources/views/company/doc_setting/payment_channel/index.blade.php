@extends('adminlte::page')
@php
    $pagename = __('doc_setting.pagename');
    $sub_pagename = __('doc_setting.pagename_4');
@endphp
@section('title', setting('title') . ' | ' . $pagename . ' | ' . $sub_pagename)
@push('css')
    <style>
        hr.cus-hr {
            border-top: 1px dotted #8c8b8b;
            border-bottom: 1px dotted #fff;
            width: 85% !important;
        }

        .custom-switch-container {
            display: flex;
            align-items: center;
        }

        .custom-switch-text {
            margin-right: 10px;
            /* Adjust as needed */
        }

        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-selection__arrow {
            height: 37px !important;
        }
    </style>
@endpush
@section('content')
    @php
        $locale = app()->getLocale();
    @endphp
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-cogs text-muted mr-2"></i> {{ $sub_pagename }}
        </div>

        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> {{ __('home.homepage') }}</a></li>
                    <li class="breadcrumb-item">{{ $pagename }}</li>
                    <li class="breadcrumb-item active">{{ $sub_pagename }}</li>
                </ol>
            </nav>
        </div>

        <div class="card {{ env('CARD_THEME') }} shadow-custom">
            {{-- <div class="card-header" style="font-size: 20px;">
                {{ $pagename }}
            </div> --}}
            <div class="card-body">
                <form method="post"
                    action="{{ route('setting-payment-channel.update', ['setting_payment_channel' => $company_id]) }}"
                    enctype="multipart/form-data" id="form">
                    @method('PUT')
                    @csrf
                    <div class="head-content">
                        <input type="hidden" name="company_id" id="company_id" value="{{ $company_id }}">
                        <div class="row">
                            <div class="col-8">
                                <h5>{{ __('doc_setting.pc_head') }}</h5>
                            </div>
                            <div class="col-4 text-right button-section-1">
                                <a class="btn btn-secondary btn-edit"><i
                                        class="fas fa-pencil mr-2"></i>{{ __('home.edit') }}</a>
                            </div>
                            <div class="col-4 text-right button-section-2" style="display: none;">
                                <a class="btn btn-secondary" onclick="window.location.reload();"><i
                                        class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                                <button class="btn {{ env('BTN_THEME') }}" onclick="submitForm()"><i
                                        class="fas fa-save mr-2"></i>{{ __('home.save') }}</button>
                            </div>
                        </div>
                        <hr class="border-1">
                        <div class="row text-md">
                            <div class="col-12 row">
                                <div class="col-12 mb-2">
                                    <label for="myCheckbox" class="checkbox-label">{{ __('doc_setting.pc_type') }}</label>
                                    <div class="ml-1 checkbox-container row">
                                        <div class="mr-3">
                                            <input type="radio" name="advance_type" id="advance_type" value="0"
                                                {{ $company_doc_settings->advance_type == 0 ? 'checked' : '' }} disabled>
                                            <span class="ml-1">{{ __('home.default') }}</span>
                                        </div>
                                        <div class="mr-3">
                                            <input type="radio" name="advance_type" id="advance_type" value="1"
                                                {{ $company_doc_settings->advance_type == 1 ? 'checked' : '' }} disabled>
                                            <span class="ml-1">{{ __('home.custom') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 payment-select-section row mb-2">

                                </div>
                                <hr class="cus-hr">
                                <div class="col-12 mb-2">
                                    <div class="custom-switch-container">
                                        <input type="hidden" id="payment_button_publish" name="payment_button_publish"
                                            value="{{ $company_doc_settings->payment_button_publish }}">
                                        <span
                                            class="custom-switch-text text-bold">{{ __('doc_setting.pc_show_payment') }}</span>
                                        <div class="custom-control custom-switch" id="status_zone" style="cursor:pointer">
                                            <input type="checkbox" class="custom-control-input" id="toggle"
                                                {{ $company_doc_settings->payment_button_publish == 1 ? 'checked' : '' }}
                                                disabled>
                                            <span class="custom-control-label" for="toggle" id="toggle_status"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-12 payment-addition-section">

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])

    @push('js')
        <script>
            function declareSelect2() {
                $('.select2').select2({
                    width: '100%',
                    templateResult: formatOption, // Custom template function
                    templateSelection: formatOption,
                });
            }

            function fileValidationCustom(ele) {
                var fileInput = ele;
                var filePath = fileInput.value;
                var maxSizeInBytes = 3145728;

                // Allowing file type
                var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;

                // Check if the file extension is allowed
                if (!allowedExtensions.exec(filePath)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'ไฟล์ที่นำเข้าต้องเป็นไฟล์รูปภาพเท่านั้น',
                        timer: 2000,
                    });
                    fileInput.value = '';
                    return false;
                }

                // Check if the file size is within the allowed limit
                if (fileInput.files[0] && fileInput.files[0].size > maxSizeInBytes) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'ขนาดของไฟล์เกินขีดจำกัดที่กำหนด',
                        timer: 2000,
                    });
                    fileInput.value = '';
                    return false;
                }

                // If both file extension and size are valid, call the previewImg function
                previewImg(fileInput);
            }

            function constructAdvanceView(advance_type) {
                let payment_section = ` <div class="col-4 mb-2">
                                    <label for="payment_option_one_id">{{ __('doc_setting.pc_payment_ch1') }}</label>
                                    <select name="payment_option_one_id" id="payment_option_one_id" class="select2" disabled>
                                        <option value=""> {{ __('home.none') }} </option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank['id'] }}" data-img="{{ $bank['image'] }}" {{ $bank['id'] == $company_doc_settings->payment_option_one_id ? 'selected' : '' }}> {{ $bank['name'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="payment_option_two_id">{{ __('doc_setting.pc_payment_ch2') }}</label>
                                    <select name="payment_option_two_id" id="payment_option_two_id" class="select2" disabled>
                                        <option value=""> {{ __('home.none') }} </option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank['id'] }}" data-img="{{ $bank['image'] }}" {{ $bank['id'] == $company_doc_settings->payment_option_two_id ? 'selected' : '' }}> {{ $bank['name'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="payment_option_three_id">{{ __('doc_setting.pc_payment_ch3') }}</label>
                                    <select name="payment_option_three_id" id="payment_option_three_id" class="select2" disabled>
                                        <option value=""> {{ __('home.none') }} </option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank['id'] }}" data-img="{{ $bank['image'] }}" {{ $bank['id'] == $company_doc_settings->payment_option_three_id ? 'selected' : '' }}> {{ $bank['name'] }} </option>
                                        @endforeach
                                    </select>
                                </div> `
                if (advance_type == 1) {
                    $('.payment-select-section').html('')
                    $('.payment-select-section').append(payment_section)
                    declareSelect2();
                    if ($('.btn-edit').data('action') == 1) {
                        $('#form :input').prop('disabled', false);
                    }
                } else {
                    $('.payment-select-section').html('')
                }
            }

            function constructPaymentPartView(toggle) {
                let payment_section = ` <div class="col-12 ml-1 checkbox-container row">
                                    <div class="mr-3">
                                        <input type="radio" name="payment_type" id="payment_type" value="1"
                                            {{ $company_doc_settings->payment_type == 1 ? 'checked' : '' }} disabled>
                                        <span class="ml-1">{{ __('doc_setting.pc_show_type1') }}</span>
                                    </div>
                                    {{-- API ยังไม่ใช้ ทำไว้เฉย ๆ --}}
                                    {{-- <div class="mr-3">
                                        <input type="radio" name="advance_type" id="advance_type" value="1"
                                            {{ $company_doc_settings->advance_type == 1 ? 'checked' : '' }} disabled>
                                        <span class="ml-1">{{ __('doc_setting.pc_show_type2') }}</span>
                                    </div> --}}
                                </div>
                                <div class="col-5 row mb-2">
                                    <div class="col-12 text-center mt-2">
                                        <div class="text-center"><img src="{{ $img }}" id="showimg"
                                            style="width:100%; height: 300px;width: 300px; max-height: 300px; max-width: 300px;object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="col-12 my-2">
                                        <input type="file" class="custom-file-input" id="image"
                                            name="image" onchange="return fileValidationCustom(this)"
                                            accept="image/*" disabled>
                                        <label class="custom-file-label">{{ __('bank.choose_file') }}</label>
                                    </div>
                                </div>
                                <div class="col-7 mb-2">
                                    <label for="">{{ __('home.notation') }}</label>
                                    <ul>
                                        @for ($i = 1; $i <= 3; $i++)
                                            <li>{{ __('doc_setting.img_notation' . $i) }}</li>
                                        @endfor
                                    </ul>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="bank_id">{{ __('payment.bank') }}</label>
                                    <select class="select2" name="bank_id" id="bank_id" disabled>
                                        @foreach ($allBanks as $a_bank)
                                            <option value="{{ $a_bank->id }}" {{ @$company_doc_settings->bank_id == $a_bank->id ? 'selected' : '' }}>
                                                {{ app()->getLocale() == 'th' ? $a_bank->name_th : $a_bank->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="account_type">{{ __('payment.account_type') }}</label>
                                    <select name="account_type" id="account_type" class="select2" disabled>
                                        <option value="1" {{ @$company_doc_settings->account_type == 1 ? 'selected' : '' }}>{{ __('payment.account_type1') }}</option>
                                        <option value="2" {{ @$company_doc_settings->account_type == 2 ? 'selected' : '' }}>{{ __('payment.account_type2') }}</option>
                                        <option value="3" {{ @$company_doc_settings->account_type == 3 ? 'selected' : '' }}>{{ __('payment.account_type3') }}</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label for="account_number">{{ __('payment.account_number') }}</label>
                                    <input type="text" class="form-control" name="account_number"
                                        id="account_number" value="{{ @$company_doc_settings->account_number }}" disabled>
                                </div> `
                if (toggle == 1) {
                    $('.payment-addition-section').html('')
                    $('.payment-addition-section').append(payment_section)
                    declareSelect2();
                    if ($('.btn-edit').data('action') == 1) {
                        $('#form :input').prop('disabled', false);
                    }
                } else {
                    $('.payment-addition-section').html('')
                }
            }

            function showPayment() {
                let status = $('#toggle').prop('checked') ? 1 : 0;
                if (status == 0) {
                    $('#toggle_status').text("{{ __('home.not_show') }}")
                    $('#payment_button_publish').val(0)
                } else {
                    $('#toggle_status').text("{{ __('home.show') }}")
                    $('#payment_button_publish').val(1)
                }
                constructPaymentPartView($('#payment_button_publish').val())
            }

            function formatOption(option) {
                if (!option.id) {
                    return option.text;
                }
                if (!$(option.element).data('img')) {
                    img = "{{ asset('assets/default.png') }}";
                } else {
                    img = "{{ url('') }}" + '/' + $(option.element).data('img')
                }
                var $option = $(
                    '<span><img class="mr-2" style="height:30px" src="' + img + '" class="img-option" /> ' + option
                    .text +
                    '</span>'
                );
                return $option;
            }

            function previewImg(id) {
                const [file] = id.files
                if (file) {
                    if (id.id === "image") {
                        showimg.src = URL.createObjectURL(file);
                    }
                }
            }

            $(document).ready(function() {
                constructAdvanceView({{ $company_doc_settings->advance_type }})
                showPayment();
                $(document).on('click', '#status_zone', function() {
                    if (!$('#toggle').prop('disabled')) {
                        let checkbox = $('#toggle')
                        checkbox.prop('checked', !checkbox.prop('checked'));
                        showPayment();
                    }
                })

                $(document).on('change', '#advance_type', function() {
                    constructAdvanceView($('#advance_type:checked').val())
                })

                $(document).on('click', '.btn-edit', function() {
                    $(this).attr("data-action", 1)
                    $('.button-section-1').hide()
                    $('.button-section-2').show()
                    $('#form :input').prop('disabled', false);
                })

                // $(document).on('click', '.btn-save', function() {
                //     var formData = new FormData();
                //     formData.append('company_id', '{{ $company_id }}')
                //     $('input[type="radio"]').each(function() {
                //         if (this.checked) {
                //             formData.append(this.name, this.value);
                //         }
                //     });

                //     url = "{{ url('/doc_setting/setting-payment-channel/update') }}";
                //     submitData(url, formData)
                // })
            });
        </script>
    @endpush

@endsection
