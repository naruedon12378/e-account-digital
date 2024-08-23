@extends('adminlte::page')
@php
    $pagename = [
        'th' => 'จัดการเงินได้/เงินหัก',
        'en' => 'Payment Financial Records',
    ];
    $locale = app()->getlocale();
@endphp
@section('title', setting('title') . ' | ' . $pagename[$locale])
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-pen text-muted mr-2"></i> {{ $pagename[$locale] }}
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
            {{-- <div class="card-header" style="font-size: 20px;">
                {{ $pagename[$locale] }}
            </div> --}}
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

                @if (Auth::user()->hasAnyPermission(['*', 'all payroll_financial_record', 'create payroll_financial_record']))
                    <div class="text-right">
                        <a href="" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2" data-toggle="modal"
                            data-target="#modal"><i class="fas fa-plus mr-2"></i> {{ __('home.add') }}</a>
                    </div>
                @endif

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th>{{ __('payroll_financial_record.account_type') }}</th>
                            {{-- <th class="text-center" style="width: 10%">{{ __('payroll_financial_record.number') }}</th> --}}
                            <th class="text-center">{{ __('payroll_financial_record.name') }}</th>
                            <th class="text-center" style="width: 10%">
                                {{ __('payroll_financial_record.account_to_be_record') }}</th>
                            <th class="text-center">{{ __('payroll_financial_record.type') }}</th>
                            <th class="text-center">{{ __('payroll_financial_record.annual_revenue') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_financial_record.status') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('payroll_financial_record.actions') }}</th>
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
            function chkFormType() {
                type = $("input[name='type_form']:checked").val();
                if (type == 'advance') {
                    $('.advance_form').css('display', '');
                } else {
                    $('.advance_form').css('display', 'none');
                }
            }

            function resetModal() {
                $('#account').prop('selectedIndex', 0).change();
                $('#annual_revenue').prop('selectedIndex', 1).change();
                $('#ssc_base_salary').prop('selectedIndex', 1).change();
                $('#id').val('');
                $('#name_th').val('');
                $('#name_en').val('');
                $('#acc_type_revenue').attr('checked', true);
                $('#type_regular').attr('checked', true);
                $('#basic_form').attr('checked', true);
                chkFormType()
            }

            // $('input[name="iswColor"]').bootstrapSwitch('state', true, true);
            var table;
            $(document).ready(function() {
                table = $('#table').DataTable({
                    order: [
                        [1, 'asc']
                    ],
                    pageLength: 10,
                    responsive: true,
                    processing: true,
                    scrollX: true,
                    scrollCollapse: true,
                    language: {
                        url: "{{ asset('plugins/datatable-th.json') }}",
                    },
                    serverSide: true,
                    ajax: "",
                    columnDefs: [{
                            orderable: false,
                            targets: [0, 2, 6]
                        },
                        {
                            targets: [5, 6],
                            className: 'text-center'
                        }
                    ],
                    columns: [{
                            data: 'account_type',
                            render: function(data, type, row, meta) {
                                let render = "";
                                if (data == 0) {
                                    render =
                                        `<span class="badge badge-success">{{ __('payroll_financial_record.revenue') }}</span>`
                                } else if (data == 1) {
                                    render =
                                        `<span class="badge badge-danger">{{ __('payroll_financial_record.deduct') }}</span>`
                                }
                                return render;
                            }
                        },
                        // {
                        //     data: 'code',
                        // },
                        {
                            data: 'name_th',
                            render: function(data, type, row, meta) {
                                let lang = "{{ app()->getLocale() }}"
                                if (lang == "th") {
                                    render = row.name_th;
                                } else {
                                    render = row.name_en;
                                }
                                return render;
                            }
                        },

                        {
                            data: 'account_code'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'annual_revenue'
                        },
                        {
                            data: 'publish'
                        },
                        {
                            data: 'btn'
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
                chkFormType();
            })

            //storeData
            function storeData(url) {
                if ($('#name_th').val() == null || $('#name_th').val() == "") {
                    toastr.error('กรุณาใส่ชื่อภาษาไทย');
                    return false;
                }

                if ($('#name_en').val() == null || $('#name_en').val() == "") {
                    toastr.error('กรุณาใส่ชื่อภาษาอังกฤษ');
                    return false;
                }
                formdata = new FormData();
                formdata.append('_token', '{{ csrf_token() }}');
                id = $('#id').val();

                if (!id) {
                    url = "{{ route('payroll_financial_record.store') }}";
                } else {
                    formdata.append('id', id);
                    url = "{{ route('payroll_financial_record.update') }}";
                }

                formdata.append('code', $('#code').val());
                formdata.append('name_th', $('#name_th').val());
                formdata.append('name_en', $('#name_en').val());
                formdata.append('type_form', $('input[name="type_form"]:checked').val());
                formdata.append('account_type', $('input[name="account_type"]:checked').val());
                formdata.append('type', $('input[name="type"]:checked').val());
                if ($('input[name="type_form"]:checked').val() == 'advance') {
                    formdata.append('account_id', $('#account option:selected').val());
                    formdata.append('annual_revenue', $('#annual_revenue option:selected').val());
                    formdata.append('ssc_base_salary', $('#ssc_base_salary option:selected').val());
                }

                submitData(url, formdata).then(function(response) {
                    $('#close-modal').click();
                });
            }

            //requestData
            function requestData(response) {
                $('#id').val(response.payroll_financial_record.id);
                $('#code').val(response.payroll_financial_record.code);
                $('#name_th').val(response.payroll_financial_record.name_th);
                $('#name_en').val(response.payroll_financial_record.name_en);
                $(`input[name="account_type"][value="${response.payroll_financial_record.type_account}"]`).prop('checked',
                    true);
                $(`input[name="type"][value="${response.payroll_financial_record.type}"]`).prop('checked', true);
                if (response.payroll_financial_record.account_id) {
                    $('#account').val(response.payroll_financial_record.account_id).change()
                }
                $('#account').val(response.payroll_financial_record.account_id).change()
                $('#annual_revenue').val(response.payroll_financial_record.annual_revenue).change()
                $('#ssc_base_salary').val(response.payroll_financial_record.ssc_base_salary).change()
                if (response.payroll_financial_record.type_form == 2) {
                    $('#advance_form').attr('checked', true)
                    $('#basic_form').attr('checked', false)
                } else {
                    $('#basic_form').attr('checked', true)
                    $('#advance_form').attr('checked', false)
                }
                chkFormType();

                $('#modal').modal('show');
            }

            $('#modal').on('hidden.bs.modal', function(e) {
                $('.btn-reset').click();
            });
        </script>
    @endpush

    @include('admin.payroll_financial_record.partials.modal')
    <script></script>
@endsection
