@extends('adminlte::page')
@php
    $pagename = [
        'th' => 'จัดการพนักงาน',
        'en' => 'Payroll Employee',
    ];
    $locale = app()->getLocale();
@endphp
@section('title', $pagename[$locale])
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-newspaper text-muted text-danger mr-2"></i> {{ $pagename[$locale] }}
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
            <form method="POST" action="{{ route('export.payroll.employee.xlsx') }}">
                @csrf
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
                            <input type="search" id="custom-search-input" name="search" class="form-control  input-search"
                                placeholder="ค้นหา">
                        </div>
                    </div>

                    @if (Auth::user()->hasAnyPermission(['*', 'all payroll_employee', 'create payroll_employee']))
                        <div class="text-right">
                            <a href="" class="btn btn-outline-success mb-2" data-toggle="modal"
                                data-target="#modal-import"><i class="fas fa-file-import mr-2"></i>
                                Import</a>
                            <button type="submit" class="btn btn-outline-danger mb-2"><i
                                    class="fas fa-file-export mr-2"></i>
                                Export</button>
                            <a href="{{ route('payroll_employee.create') }}"
                                class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2"><i class="fas fa-plus mr-2"></i>
                                {{ __('home.add') }}</a>
                        </div>
                    @endif

                    <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                        <thead class="bg-custom">
                            <tr>
                                <th class="text-center" style="width: 10%">{{ __('payroll_employee.number') }}</th>
                                <th class="text-center">{{ __('payroll_employee.fullname') }}</th>
                                <th class="text-center">{{ __('payroll_employee.department') }}</th>
                                <th class="text-center" style="width: 10%">{{ __('payroll_employee.position') }}</th>
                                <th class="text-center" style="width: 10%">{{ __('payroll_employee.salary') }}</th>
                                <th class="text-center" style="width: 10%">{{ __('payroll_employee.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </form>
        </div>
    </div>

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])

@push('js')
    <script>
        function importData() {
            let file = $('#import_doc')[0].files[0];
            if (file) {
                var fileName = file.name;
                var fileExtension = fileName.split('.').pop().toLowerCase();
                var allowedExtensions = ['xls', 'xlsx'];

                if (allowedExtensions.indexOf(fileExtension) !== -1) {
                    var formData = new FormData();
                    formData.append('file', file);
                    $.ajax({
                        url: "{{ route('import.payroll.employee') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === true) {
                                Swal.fire({
                                    title: response.msg,
                                    icon: 'success',
                                    toast: true,
                                    position: 'top-right',
                                    timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                                setTimeout(function() {
                                    window.location.reload()
                                }, 2000);
                            } else {
                                Swal.fire({
                                    title: response.msg,
                                    icon: 'error',
                                    toast: true,
                                    position: 'top-right',
                                    timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                        }
                    })
                } else {
                    toastr.error('ไฟล์ไม่อนุญาต!');
                    $('.custom-file-label').text('Choose File')
                    $('#import_doc').val('');
                }
            } else {
                toastr.error('กรุณาเลือกไฟล์เอกสาร!');
            }
        }

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var table;
        $(document).ready(function() {
            table = $('#table').DataTable({
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
                        className: 'text-center',
                        targets: [0, 3, 4, 5]
                    },
                    // {
                    //     orderable: false,
                    //     targets: [1, 3, 4]
                    // },
                ],
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'department_text',
                    },
                    {
                        data: 'position'
                    },
                    {
                        data: 'salary',
                        render: function(data, type, row, meta) {
                            return formatter.format(data) + ' ฿';
                        },
                    },
                    {
                        data: 'btn'
                    },
                ],
                "dom": 'rtip',
            });
        });

        // Custom search
        $('#custom-search-input').keyup(function() {
            var columns = [1];
            $.each(columns, function(index, value) {
                table.column(value).search($('#custom-search-input').val()).draw();
            });
        })
    </script>
@endpush
@include('admin.payroll_employee.partials.import-modal')
@endsection
