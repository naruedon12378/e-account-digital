@extends('adminlte::page')
@php
    $pagename = __('doc_setting.pagename');
    $sub_pagename = __('doc_setting.pagename_6');
@endphp
@section('title', setting('title') . ' | ' . $pagename . ' | ' . $sub_pagename)
@push('css')
    <style>
        hr.cus-hr {
            border-top: 1px dotted #8c8b8b;
            border-bottom: 1px dotted #fff;
            width: 85% !important;
        }
    </style>
@endpush
@section('content')
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
                    action="{{ route('setting-public-link.update', ['setting_public_link' => $company_id]) }}"
                    enctype="multipart/form-data" id="form">
                    <div class="head-content">
                        <input type="hidden" name="company_id" id="company_id" value="{{ $company_id }}">
                        <div class="row">
                            <div class="col-8">
                                <h5>{{ __('doc_setting.pl_head') }}</h5>
                                <p class="text-black-50">{{ __('doc_setting.pl_label') }}</p>
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

                        @method('PUT')
                        @csrf
                        <div class="row text-md">
                            <div class="col-12 row">
                                <div class="col-4">
                                    <label for="myCheckbox"
                                        class="checkbox-label text-black-50">{{ __('doc_setting.pl_signature') }}</label>
                                </div>
                                <div class="col-8">
                                    <div class="checkbox-container row">
                                        <div class="w-25">
                                            <input type="radio" name="status_signature" id="status_signature"
                                                value="1"
                                                {{ $company_doc_settings->status_signature == 1 ? 'checked' : '' }}
                                                disabled>
                                            <span class="ml-2">{{ __('home.show') }}</span>
                                        </div>
                                        <div class="w-25">
                                            <input type="radio" name="status_signature" id="status_signature"
                                                value="0"
                                                {{ $company_doc_settings->status_signature == 0 ? 'checked' : '' }}
                                                disabled>
                                            <span class="ml-2">{{ __('home.not_show') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="col-4">
                                    <label for="myCheckbox"
                                        class="checkbox-label  text-black-50">{{ __('doc_setting.pl_stamp') }}</label>
                                </div>
                                <div class="col-8">
                                    <div class="checkbox-container row">
                                        <div class="w-25">
                                            <input type="radio" name="status_company_seal" id="status_company_seal"
                                                value="1"
                                                {{ $company_doc_settings->status_company_seal == 1 ? 'checked' : '' }}
                                                disabled>
                                            <span class="ml-2">{{ __('home.show') }}</span>
                                        </div>
                                        <div class="w-25">
                                            <input type="radio" name="status_company_seal" id="status_company_seal"
                                                value="0"
                                                {{ $company_doc_settings->status_company_seal == 0 ? 'checked' : '' }}
                                                disabled>
                                            <span class="ml-2">{{ __('home.not_show') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="col-4">
                                    <label for="myCheckbox"
                                        class="checkbox-label  text-black-50">{{ __('doc_setting.pl_password') }}</label>
                                </div>
                                <div class="col-8">
                                    <div class="checkbox-container row">
                                        <div class="w-25">
                                            <input type="radio" name="status_doc_access_code" id="status_doc_access_code"
                                                value="1"
                                                {{ $company_doc_settings->status_doc_access_code == 1 ? 'checked' : '' }}
                                                disabled>
                                            <span class="ml-2">{{ __('home.active') }}</span>
                                        </div>
                                        <div class="w-25">
                                            <input type="radio" name="status_doc_access_code" id="status_doc_access_code"
                                                value="0"
                                                {{ $company_doc_settings->status_doc_access_code == 0 ? 'checked' : '' }}
                                                disabled>
                                            <span class="ml-2">{{ __('home.not_active') }}</span>
                                        </div>
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
            $(document).ready(function() {
                $(document).on('click', '.btn-edit', function() {
                    $('.button-section-1').hide()
                    $('.button-section-2').show()

                    $('input:radio').prop('disabled', false)
                })

                // $(document).on('click', '.btn-save', function() {
                //     var formData = new FormData();
                //     formData.append('company_id', '{{ $company_id }}')
                //     $('input[type="radio"]').each(function() {
                //         if (this.checked) {
                //             formData.append(this.name, this.value);
                //         }
                //     });

                //     url = "{{ url('/doc_setting/setting-public-link/update') }}";
                //     submitData(url, formData)
                // })
            });
        </script>
    @endpush

@endsection
