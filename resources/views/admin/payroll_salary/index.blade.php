@extends('adminlte::page')
@php
    $pagename = [
        'th' => 'จัดการจ่ายงินเดือน',
        'en' => 'Payroll Salary',
    ];
    $locale = app()->getLocale();
@endphp
@section('title', setting('title') . ' | ' . $pagename[$locale])
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-user text-muted mr-2"></i> {{ $pagename[$locale] }}
        </div>

        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> {{ __('home.homepage') }}</a></li>
                    <li class="breadcrumb-item active">{{ $pagename[$locale] }}</li>
                </ol>
            </nav>
        </div>
        <div class="card {{ env('CARD_THEME') }} shadow-custom">
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="group">
                                <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                                    <g>
                                        <path
                                            d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                                        </path>
                                    </g>
                                </svg>
                                <input type="search" id="custom-search-input" name="search"
                                    class="form-control input-search" placeholder="ค้นหา">

                            </div>
                        </div>
                        <div class="col-4">
                            <select class="form-control select2 status_select" name="status">
                                <option value="">{{ __('payroll_salary.ALL') }}</option>
                                <option value="0">{{ __('payroll_salary.DRAFT') }}</option>
                                <option value="1">{{ __('payroll_salary.AWAIT') }}</option>
                                <option value="2">{{ __('payroll_salary.OUTSTANDING') }}</option>
                                <option value="3">{{ __('payroll_salary.PAID') }}</option>
                                <option value="4">{{ __('payroll_salary.VOID') }}</option>
                            </select>
                        </div>
                        @if (Auth::user()->hasAnyPermission(['*', 'all payroll_salary', 'create payroll_salary']))
                            <div class="col-4 text-right">
                                <a href="{{ route('payroll_salary.create') }}"
                                    class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2"><i class="fas fa-plus mr-2"></i>
                                    {{ __('payroll_salary.create_salary_pay_run') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </form>

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary.salary_code') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary.issued_date') }}</th>
                            <th class="text-center">{{ __('payroll_salary.number_of_employee') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary.cycle_date') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary.payment_date') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary.payment_amount') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary.status') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary.actions') }}</th>
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
                        orderable: false,
                        targets: [4, 5, 6, 7]
                    }, ],
                    columns: [{
                            data: 'code'
                        },
                        {
                            data: 'issue_date',
                            render: function(data, type, row, meta) {
                                value = moment(data).format('DD/MM/YYYY')
                                return value;
                            },
                            className: 'text-center col-1'
                        },
                        {
                            data: 'payroll_salary_details',
                            render: function(data, type, row, meta) {
                                value = data.length
                                return value;
                            },
                            className: 'text-center col-1'
                        },
                        {
                            data: 'issue_date',
                            render: function(data, type, row, meta) {
                                dateStart = moment(row.from_date).format('DD/MM/YYYY')
                                dateEnd = moment(row.to_date).format('DD/MM/YYYY')
                                value = dateStart + " - " + dateEnd
                                return value;
                            },
                            className: 'text-center col-1'
                        },
                        {
                            data: 'due_date',
                            render: function(data, type, row, meta) {
                                value = moment(data).format('DD/MM/YYYY')
                                return value;
                            },
                            className: 'text-center col-1'
                        },
                        {
                            data: 'net_amount',
                            render: function(data, type, row, meta) {
                                value = formatter2Digit.format(data)
                                return value;
                            },
                            className: 'text-right col-1'
                        },
                        {
                            data: 'status',
                            render: function(data, type, row, meta) {
                                var statusTextArray = {
                                    th: ['แบบร่าง',
                                        'รออนุมัติ',
                                        'รอชำระ',
                                        'ชำระแล้ว',
                                        'ถังขยะ'
                                    ],
                                    en: [
                                        'Draft',
                                        'Await Approval',
                                        'Outstanding',
                                        'Paid',
                                        'Voided'
                                    ]

                                };

                                value = statusTextArray['{{ $locale }}'][data]
                                return value;
                            },
                            className: 'text-center col-1'
                        },
                        {
                            data: 'btn',
                            className: 'text-center col-1'
                        },
                    ],
                    "dom": 'rtip',
                });
            });

            //custom search datatable
            $('#custom-search-input').keyup(function() {
                table.search($(this).val()).draw();
            })

            $('.status_select').change(function() {
                let val = $.fn.dataTable.util.escapeRegex($(this).val());
                table.column(6).search(val ? '^' + val + '$' : '', true, false).draw();
            })
        </script>
    @endpush
@endsection
