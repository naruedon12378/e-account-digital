@extends('adminlte::page')
@php
    $pagename = __('payment.page_name');
@endphp
@section('title', setting('title') . ' | ' . $pagename)
@push('css')
    <style>
        hr.cus-hr {
            border-top: 1px dotted #8c8b8b;
            border-bottom: 1px dotted #fff;
            width: 85% !important;
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
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-cogs text-muted mr-2"></i> {{ $pagename }}
        </div>

        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> {{ __('home.homepage') }}</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>

        <div class="card {{ env('CARD_THEME') }} shadow-custom">
            <div class="card-body">
                <div class="float-left mb-2">
                    <div class="group">
                        <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                            <g>
                                <path
                                    d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                                </path>
                            </g>
                        </svg>
                        <input type="search" id="custom-search-input" class="form-control  input-search"
                            placeholder="ค้นหา">
                    </div>
                </div>

                @if (Auth::user()->hasAnyPermission(['*', 'all user', 'create user']))
                    <div class="text-right">
                        <a class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2 btn-add"><i
                                class="fas fa-plus mr-2"></i>{{ __('home.add') }}</a>
                    </div>
                @endif

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center">{{ __('payment.type') }}</th>
                            <th class="text-center">{{ __('payment.name') }}</th>
                            <th class="text-center">{{ __('payment.remark') }}</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])

    @push('js')
        <script>
            var table;
            $(document).ready(function() {
                table = $('#table').DataTable({
                    pageLength: 50,
                    responsive: true,
                    processing: true,
                    scrollX: true,
                    scrollCollapse: true,
                    language: {
                        url: "{{ asset('plugins/DataTables/th.json') }}",
                    },
                    serverSide: true,
                    ajax: "",
                    columnDefs: [{
                            className: 'text-center',
                            targets: [0, 2]
                        },
                        {
                            orderable: false,
                            targets: [2]
                        },
                    ],
                    columns: [{
                            data: 'type',
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'remark'
                        },
                        {
                            data: 'btn',
                        },
                    ],
                    "dom": 'rtip',
                });
            });

            //custom search datatable
            $('#custom-search-input').keyup(function() {
                table.search($(this).val()).draw();
            })

            $('#modal').on('hidden.bs.modal', function(event) {
                $("#form")[0].reset();
                $('#id').val('');
                $('.is-valid').removeClass('is-valid');
            })

            $('.btnReset').on('click', function(event) {
                $("#form")[0].reset();
                $('.is-valid').removeClass('is-valid');
            })

            $('.btn-add').on('click', function(event) {
                createForm();
                $('#staticBackdropLabel').text('{{ __('home.add') }}')
                $('#modal').modal('show');
            })

            $('.chk-group').on('change', function(event) {
                createForm();
            })

            function createForm() {
                let financial_type = $('input[type="radio"][id="financial_type"]:checked').val();
                if (financial_type == 1 || financial_type == 3) {
                    dataForm = `
                    <div class="col-6 mb-2">
                        <label for="account_name">{{ __('payment.account_name') }}</label>
                        <input type="text" class="form-control" name="account_name" id="account_name">
                    </div>
                    <div class="col-12 mb-2">
                        <label for="remark">{{ __('payment.remark') }}</label>
                        <textarea name="remark" id="remark" class="form-control"></textarea>
                    </div>
                    <div class="col-12 mx-0 my-1 row">
                        <div class="form-check mr-2">
                            <input type="checkbox" class="form-check-input" name="income_status"
                                id="income_status">
                            <span class="form-check-label">{{ __('payment.income_status') }}</span>
                        </div>
                        <div class="form-check mr-2">
                            <input type="checkbox" class="form-check-input" name="expense_status"
                                id="expense_status">
                            <span class="form-check-label">{{ __('payment.expense_status') }}</span>
                        </div>
                    </div>
                `;
                    $('.section-form').html('');
                    $('.section-form').append(dataForm);
                } else if (financial_type == 2) {
                    dataForm = `
                    <div class="col-6 mb-2">
                        <label for="bank_id">{{ __('payment.bank') }}</label>
                        <select class="select2" name="bank_id" id="bank_id">
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">
                                    {{ app()->getLocale() == 'th' ? $bank->name_th : $bank->name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="account_type">{{ __('payment.account_type') }}</label>
                        <select name="account_type" id="account_type" class="select2">
                            <option value="1">{{ __('payment.account_type1') }}</option>
                            <option value="2">{{ __('payment.account_type2') }}</option>
                            <option value="3">{{ __('payment.account_type3') }}</option>
                        </select>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="account_name">{{ __('payment.account_name') }}</label>
                        <input type="text" class="form-control" name="account_name" id="account_name">
                    </div>
                    <div class="col-6 mb-2">
                        <label for="account_number">{{ __('payment.account_number') }}</label>
                        <input type="text" class="form-control" name="account_number" id="account_number">
                    </div>
                    <div class="col-6 mb-2">
                        <label for="branch_name">{{ __('payment.account_branch_name') }}</label>
                        <input type="text" class="form-control" name="branch_name" id="branch_name">
                    </div>
                    <div class="col-6 mb-2">
                        <label for="branch_code">{{ __('payment.account_branch_code') }}</label>
                        <input type="text" class="form-control" name="branch_code" id="branch_code">
                    </div>
                    <div class="col-12 mb-2">
                        <label for="remark">{{ __('payment.remark') }}</label>
                        <textarea name="remark" id="remark" class="form-control"></textarea>
                    </div>
                    <div class="col-12 mx-0 my-1 row">
                        <div class="form-check mr-2">
                            <input type="checkbox" class="form-check-input" name="income_status"
                                id="income_status">
                            <span class="form-check-label">{{ __('payment.income_status') }}</span>
                        </div>
                        <div class="form-check mr-2">
                            <input type="checkbox" class="form-check-input" name="expense_status"
                                id="expense_status">
                            <span class="form-check-label">{{ __('payment.expense_status') }}</span>
                        </div>
                        <div class="form-check mr-2">
                            <input type="checkbox" class="form-check-input" name="pay_check_status"
                                id="pay_check_status">
                            <span class="form-check-label">{{ __('payment.pay_check_status') }}</span>
                        </div>
                    </div>
                `;
                    $('.section-form').html('');
                    $('.section-form').append(dataForm);
                    $('.select2').select2({
                        dropdownParent: $("#modal"),
                        width: '100%',
                    });
                }
            }

            //requestData
            function requestData(response) {
                $('#id').val(response.data.id);
                $('input:radio[name="financial_type"][value="' + response.data.financial_type + '"]').prop('checked',
                    true);
                createForm();

                // setData
                $('#account_name').val(response.data.account_name)
                $('#remark').text(response.data.remark)
                if (response.data.income_status == 1) {
                    $('#income_status').prop('checked', true)
                }
                if (response.data.expense_status == 1) {
                    $('#expense_status').prop('checked', true)
                }

                if (response.data.financial_type == 2) {
                    if (response.data.pay_check_status == 1) {
                        $('#pay_check_status').prop('checked', true)
                    }
                    $('#bank_id').val(response.data.bank_id).change()
                    $('#account_type').val(response.data.account_type).change()
                    $('#account_number').val(response.data.account_number)
                    $('#branch_name').val(response.data.branch_name)
                    $('#branch_code').val(response.data.branch_code)
                }
                $('#staticBackdropLabel').text('{{ __('home.edit') }}')
                $('#modal').modal('show');
            }

            function storeData(url) {
                let financial_type = $('input[type="radio"][id="financial_type"]:checked').val();
                formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('financial_type', financial_type);
                formData.append('company_id', {{ $company_id }});
                formData.append('account_name', $('#account_name').val());
                formData.append('remark', $('#remark').val());
                formData.append('income_status', $('#income_status').is(":checked") ? 1 : 0);
                formData.append('expense_status', $('#expense_status').is(":checked") ? 1 : 0);
                if (financial_type == 2) {
                    formData.append('bank_id', $('#bank_id').val());
                    formData.append('account_type', $('#account_type').val());
                    formData.append('account_number', $('#account_number').val());
                    formData.append('branch_name', $('#branch_name').val());
                    formData.append('branch_code', $('#branch_code').val());
                    formData.append('pay_check_status', $('#pay_check_status').is(":checked") ? 1 : 0);
                }
                if (!$('#id').val()) {
                    url = "{{ url('/setting-payment/store') }}";
                    submitData(url, formData).then(function(response) {
                        $('#close-modal').click();
                    })
                } else {
                    formData.append('id', $('#id').val());
                    url = "{{ url('/setting-payment/update') }}";
                    submitData(url, formData).then(function(response) {
                        $('#close-modal').click();
                    })
                }
            }
        </script>
    @endpush

    @include('company.payment_method.partials.data-modal')
@endsection
