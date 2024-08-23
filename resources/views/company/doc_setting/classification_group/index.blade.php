@extends('adminlte::page')
@php
    $pagename = __('doc_setting.pagename');
    $sub_pagename = __('doc_setting.pagename_5');
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

                @if (Auth::user()->hasAnyPermission(['*', 'doc_setting']))
                    <div class="text-right">
                        <a href="" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2" data-toggle="modal"
                            data-target="#modal"><i class="fas fa-plus mr-2"></i> {{ __('home.add') }}</a>
                    </div>
                @endif

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center">{{ __('doc_setting.group_no') }}</th>
                            <th class="text-center">{{ __('doc_setting.name') }}</th>
                            <th class="text-center">{{ __('doc_setting.items') }}</th>
                            <th class="text-center">{{ __('doc_setting.document') }}</th>
                            <th class="text-center">{{ __('doc_setting.in_use') }}</th>
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
            // $('input[name="iswColor"]').bootstrapSwitch('state', true, true);
            var sts_email;
            var sts;

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
                            targets: [0, 2, 4, 5]
                        },
                        {
                            orderable: false,
                            targets: [2, 4]
                        },
                    ],
                    columns: [{
                            data: 'classification_code',
                        },
                        {
                            data: 'name',
                        },
                        {
                            data: 'items'
                        },
                        {
                            data: 'show_area'
                        },
                        {
                            data: 'publish',
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
                $("#form2")[0].reset();
                $('#id').val('');
                $('#group_id').val('');
                $('.is-valid').removeClass('is-valid');
                $('.btn-save-child').text({{ __('home.add') }})
            })

            $('.btnReset').on('click', function(event) {
                $("#form")[0].reset();
                $("#form2")[0].reset();
                $('.is-valid').removeClass('is-valid');
            })

            //storeData
            function storeData(url) {
                if ($('#form').valid()) {
                    if (!$('#publish_income').is(":checked") && !$('#publish_expense').is(":checked")) {
                        alert('{{ __('doc_setting.alert_2') }}')
                    } else {
                        formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('classification_code', $('#classification_code').val());
                        formData.append('name', $('#name').val());
                        formData.append('company_id', {{ $company_id }});
                        formData.append('description', $('#description').val());
                        formData.append('publish_income', $('#publish_income').is(":checked") ? 1 : 0);
                        formData.append('publish_expense', $('#publish_expense').is(":checked") ? 1 : 0);
                        if (!$('#id').val()) {
                            url = "{{ url('/doc_setting/setting-classification-group/store') }}";
                            submitData(url, formData).then(function(response) {
                                $('#close-modal').click();
                            })
                        } else {
                            formData.append('id', $('#id').val());
                            url = "{{ url('/doc_setting/setting-classification-group/update') }}";
                            submitData(url, formData).then(function(response) {
                                $('#close-modal').click();
                            })
                        }
                    }
                }
            }

            function viewData(url) {
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(response) {
                        $('.group-name').text(response.data.name)
                        $('.group-description').text(response.data.description)
                        $('#group_id').val(response.data.id)
                        $('#main_code').val(response.data.classification_code)
                        $('.main_code_show').text(response.data.classification_code + '-')
                        let rows = "";
                        let tbody = $('#child-tbody')
                        if (response.data.setting_classification_branches.length > 0) {
                            let editStockUrl = "{{ route('setting-classification-branch.edit', ':id') }}"
                            let deleteStockUrl = "{{ route('setting-classification-branch.destroy', ':id') }}"
                            $.each(response.data.setting_classification_branches, function(index, value) {
                                let editUrl = editStockUrl.replace(':id', value.id)
                                let deleteUrl = deleteStockUrl.replace(':id', value.id)
                                rows += `
                                    <tr>
                                        <td>${value.classification_branch_code}</td>
                                        <td>${value.name}</td>
                                        <td>${value.description == null ? "" : value.description}</td>
                                        <td>
                                            <a class="btn btn-sm btn-warning ml-1" onclick="childEdit('${editUrl}',${response.data.id})"><i class="fa fa-pencil" data-toggle="tooltip" title="แก้ไข"></i></a>
                                            <a class="btn btn-sm btn-danger ml-1" onclick="childDelete('${deleteUrl}',${response.data.id})"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></a>
                                        </td>
                                    </tr>
                                `
                            });
                            tbody.html('')
                            tbody.append(rows)
                        } else {
                            tbody.html('')
                        }
                        $('#modal-child').modal('show');
                    }
                });
            }

            function childEdit(url) {
                $('.btn-save-child').text("{{ __('home.save') }}")
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(response) {
                        let code = response.data.classification_branch_code;
                        let remove = $('#main_code').val() + '-';
                        var only_branch_code = code.replace(new RegExp(remove, "g"), "");

                        $('#child_id').val(response.data.id)
                        $('#classification_branch_code').val(only_branch_code)
                        $('#classification_branch_name').val(response.data.name)
                        $('#classification_branch_description').val(response.data.description)
                    }
                });
            }

            function childDelete(url, group_id) {
                let editUrl = "{{ route('setting-classification-group.edit', ':id') }}"
                let viewUrl = editUrl.replace(':id', group_id)
                Swal.fire({
                    title: 'ต้องการลบใช่หรือไม่',
                    text: 'หากลบข้อมูล ข้อมูลอื่นๆที่เกี่ยวข้องจะถูกลบทั้งหมด',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ตกลง',
                    cancelButtonText: 'ยกเลิก',
                    reverseButtons: true,
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false, // ไม่ให้คลิกภายนอกเพื่อปิด Alert
                    preConfirm: () => {
                        return $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                _token: CSRF_TOKEN
                            },
                            dataType: 'JSON',
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
                                    viewData(viewUrl)
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
                            }
                        });
                    },
                });
            }

            function storeChild() {
                let group_id = $('#group_id').val();
                let editUrl = "{{ route('setting-classification-group.edit', ':id') }}"
                let viewUrl = editUrl.replace(':id', group_id)
                if ($('#form2').valid()) {
                    formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('classification_branch_code', $('#main_code').val() + '-' + $(
                            '#classification_branch_code')
                        .val());
                    formData.append('name', $('#classification_branch_name').val());
                    formData.append('description', $('#classification_branch_description').val());
                    formData.append('group_id', group_id);

                    if (!$('#child_id').val()) {
                        url = "{{ route('setting-classification-branch.store') }}";
                        submitData(url, formData).then(function(response) {
                            viewData(viewUrl)
                            $("#form2")[0].reset();
                            $('.is-valid').removeClass('is-valid');
                        })
                    } else {
                        formData.append('id', $('#child_id').val());
                        updateUrl = "{{ route('setting-classification-branch.update', ':id') }}";
                        url = updateUrl.replace(':id', $('#child_id').val())
                        submitData(url, formData).then(function(response) {
                            viewData(viewUrl)
                            $("#form2")[0].reset();
                            $('.is-valid').removeClass('is-valid');
                        })
                    }
                }
            }

            function clearChildInput() {
                $('#form2')[0].reset();
            }

            //requestData
            function requestData(response) {
                $('#id').val(response.data.id);
                $('#classification_code').val(response.data.classification_code);
                $('#name').val(response.data.name);
                $('#description').val(response.data.description);
                if (response.data.publish_income == 1) {
                    $('#publish_income').prop('checked', true)
                } else {
                    $('#publish_income').prop('checked', false)
                }
                if (response.data.publish_expense == 1) {
                    $('#publish_expense').prop('checked', true)
                } else {
                    $('#publish_expense').prop('checked', false)
                }
                $('#modal').modal('show');
            }


            function changeStatus(url) {
                Swal.fire({
                    title: 'ต้องการลบใช่หรือไม่',
                    text: 'หากลบข้อมูล ข้อมูลจะถูกย้ายไปอยู่ที่หน้าประวัติผู้ใช้งาน',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ตกลง',
                    cancelButtonText: 'ยกเลิก',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: url,
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
                                    table.ajax.reload();
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
                            }
                        });

                    }
                });
            }
        </script>
    @endpush

    @include('company.doc_setting.classification_group.partials.data-modal')
    @include('company.doc_setting.classification_group.partials.child-modal')
@endsection
