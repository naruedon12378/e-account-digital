@extends('adminlte::page')
@php
    $pagename = [
        'th' => 'สรุปจ่ายเงินเดือน',
        'en' => 'Salary Summary Report',
    ];
    $locale = app()->getLocale();
    $firstdate_of_year = date('01/01/Y');
    $lastdate_of_year = date('31/12/Y');
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
                        <div class="col-8">
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
                        @if (Auth::user()->hasAnyPermission(['*', 'all payroll_salary', 'create payroll_salary']))
                            <div class="col-4 text-right">
                                <a href="" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2" data-toggle="modal"
                                    data-target="#modal-create"><i class="fas fa-plus mr-2"></i>
                                    {{ __('payroll_salary_summary.create') }}</a>
                            </div>
                        @endif
                    </div>
                </form>

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary_summary.salary_code') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary_summary.issued_date') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary_summary.cycle_date') }}</th>
                            <th class="text-center">{{ __('payroll_salary_summary.number_of_employee') }}</th>
                            <th class="text-center">{{ __('payroll_salary_summary.number_of_payrun') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary_summary.payment_amount') }}
                            </th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_salary_summary.status') }}</th>
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

            function resetModal() {
                $('#from_date').val("{{ $firstdate_of_year }}");
                $('#to_date').val("{{ $lastdate_of_year }}");
            }

            $(document).ready(function() {
                resetModal()

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
                            data: 'payroll_salary_details',
                            render: function(data, type, row, meta) {
                                value = data.length
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
                                    th: [
                                        'อนุมัติแล้ว',
                                        '{{ __('home.close') }}'
                                    ],
                                    en: [
                                        'Approve',
                                        'Voided'
                                    ]
                                };

                                value = statusTextArray['{{ $locale }}'][data]
                                return value;
                            },
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

            function storeData(url) {
                if ($('#from_date').val() == null || $('#from_date').val() == "") {
                    toastr.error('{{ __('payroll_salary_summary.toast_alert_from_date') }}');
                    return false;
                }

                if ($('#to_date').val() == null || $('#to_date').val() == "") {
                    toastr.error('{{ __('payroll_salary_summary.toast_alert_to_date') }}');
                    return false;
                }

                url = "{{ route('payroll_salary_summary.store') }}";

                formdata = new FormData();
                formdata.append('_token', '{{ csrf_token() }}');
                formdata.append('from_date', $('#from_date').val());
                formdata.append('to_date', $('#to_date').val());

                submitData(url, formdata).then(function(response) {
                    $('#close-modal').click();
                });
            }
        </script>
    @endpush

    @include('admin.payroll_salary_summary.partials.create-modal')
@endsection
