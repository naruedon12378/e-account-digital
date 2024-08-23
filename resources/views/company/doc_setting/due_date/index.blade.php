@extends('adminlte::page')
@php
    $pagename = __('doc_setting.pagename');
    $sub_pagename = __('doc_setting.pagename_3');
@endphp
@section('title', setting('title') . ' | ' . $pagename . ' | ' . $sub_pagename)
@section('style')
    <style>

    </style>
@endsection
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
        <form method="post" action="{{ route('setting-due-date.update', ['setting_due_date' => $company_id]) }}"
            enctype="multipart/form-data" id="form">
            @method('PUT')
            @csrf
            <input type="hidden" name="company_id" id="company_id" value="{{ $company_id }}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card {{ env('CARD_THEME') }} card-outline">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs pull-right" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ env('TEXT_THEME') }} active" id="income-tab" data-toggle="tab"
                                        href="#income" role="tab" aria-controls="income"
                                        aria-selected="true">{{ __('doc_setting.income') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ env('TEXT_THEME') }}" id="expense-tab" data-toggle="tab"
                                        href="#expense" role="tab" aria-controls="expense"
                                        aria-selected="false">{{ __('doc_setting.expense') }}</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="income" role="tabpanel"
                                    aria-labelledby="income-tab">
                                    @include('company.doc_setting.due_date.partials.edit_income')
                                </div>
                                <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
                                    @include('company.doc_setting.due_date.partials.edit_expense')
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="float-right">
                                <a class="btn btn-secondary" onclick="history.back();"><i
                                        class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                                <button class="btn {{ env('BTN_THEME') }}" onclick="submitForm()"><i
                                        class="fas fa-save mr-2"></i>{{ __('home.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
@section('plugins.Sweetalert2', true)

@push('js')
    <script>
        function submitForm() {
            var formData = {};
            var inputGroups = document.querySelectorAll('.input-group');

            inputGroups.forEach(function(inputGroup) {
                var label = inputGroup.querySelector('label').innerText.trim();
                var input = inputGroup.querySelector('input');
                var inputValue = input.value;

                // Create an array for each label and add the input value
                if (!formData[label]) {
                    formData[label] = [];
                }

                formData[label].push(inputValue);
            });

            // Log the data for demonstration purposes (you can send it to the server)
        }

        $(document).ready(function() {
            $(document).on('change', '.format-element', function() {
                let doc_type = $(this).data('type');
                let selected = $(this).find(":selected").val();
                if (selected == 3 || selected == 4) {
                    $(`#length_due_date_${doc_type}`).prop("disabled", true);
                } else {
                    $(`#length_due_date_${doc_type}`).prop("disabled", false);
                }
            })
        });
    </script>
@endpush
@endsection
