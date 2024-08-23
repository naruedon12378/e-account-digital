@extends('adminlte::page')
@php $pagename = 'จัดการคลังสินค้า'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')

@include('vendor.adminlte.partials.common.breadcrumb', ['pagename' => $pagename])

<div class="">

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
                @if (Auth::user()->hasAnyPermission(['*', 'all product_category', 'create product_category']))
                    <div class="text-right">
                        <a href="" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2" data-toggle="modal"
                            data-target="#modal-create" id="btnNewItem"><i class="fas fa-plus mr-2"></i> เพิ่มข้อมูล</a>
                    </div>
                @endif

                <table id="table" class="table table-hover dataTable no-footer nowrap">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" width="100">{{ __('warehouse.code') }}</th>
                            <th class="text-center" width="150">{{ __('warehouse.branch') }}</th>
                            <th class="text-center">{{ __('warehouse.name_th') }}</th>
                            <th class="text-center">{{ __('warehouse.name_en') }}</th>
                            <th class="text-center" width="100">{{ __('warehouse.status') }}</th>
                            <th class="text-center" width="150">{{ __('warehouse.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11']) -->

    @push('js')
        <script>

            formSubmitLoading( false );

            var table;
            $(document).ready(function() {
                table = $('#table').DataTable({
                    pageLength: 50,
                    responsive: true,
                    processing: true,
                    scrollX: true,
                    scrollCollapse: true,
                    serverSide: true,
                    searchDelay: 500,
                    language: {
                        url: "{{ asset('plugins/DataTables/th.json') }}",
                    },
                    ajax: "",
                    columnDefs: [
                        {
                            className: 'text-center',
                            targets: [0, 4, 5]
                        },
                        {
                            orderable: false,
                            targets: [0, 4 ,5]
                        },
                    ],
                    columns: [
                        {
                            data: 'code',
                        },
                        {
                            data: 'branch_name',
                        },
                        {
                            data: 'name_th',
                        },
                        {
                            data: 'name_en',
                        },
                        {
                            data: 'publish'
                        },
                        {
                            data: 'action'
                        }

                    ],
                    order: [
                        [1, 'asc']
                    ],
                    "dom": 'rtip',
                });
            });
            $('#custom-search-input').keyup(function() {
                table.search($(this).val()).draw();
            })
             $('#modal-create').on('hidden.bs.modal', function(event) {
                $("#form")[0].reset();
            })

            $('#modal-edit').on('hidden.bs.modal', function(event) {
                $("#form")[0].reset();
            })

            $('#btnNewItem').on('click', function() {
                $('#id').val(null);
                $('#code').val(null);
                $('#name_th').val(null);
                $('#name_en').val(null);
                $('#branch_id').val(null);
                $('#isactive_true').attr('checked',true);
                $('.label').html("{{ __('home.add') }}");
            });

            function requestData(response) {
                $('#id').val(response.warehouse.id);
                $('#code').val(response.warehouse.code);
                $('#name_th').val(response.warehouse.name_th);
                $('#name_en').val(response.warehouse.name_en);
                $('#branch_id').val(response.warehouse.branch_id);
                if( !response.warehouse.is_active ){
                    $('#isactive_false').attr('checked',true);
                }else{
                    $('#isactive_true').attr('checked',true);
                }
                $('#label').html( "{{ __('home.edit') }}" );
                $('#modal-create').modal('show');
            }

            function validationData(){

                $('.invalid').html('');

                let status = true;
                if ($('#name_th').val() == null || $('#name_th').val() == "") {
                    // toastr.error('กรุณาใส่ชื่อภาษาไทย');
                    $('.invalid.name_th').html('กรุณาใส่ชื่อภาษาไทย');
                    status = false;
                }

                if ( !$('#branch_id').val()) {
                    // toastr.error('กรุณาเลือกประเภทสินค้า');
                    $('.invalid.branch_id').html('กรุณาเลือกสาขา');
                    status = false;
                }

                return status;
            }

            function storeorUpdateData(url) {

                if( !validationData() ){
                    return;
                }

                url = "{{ route('warehouse.store') }}";
                let formData = new FormData($('#form')[0]);
                formData.append('_token', '{{ csrf_token() }}');

                const id = $('#id').val()
                if( id && id>0 ){
                    url = "{{ route('warehouse.update', ['warehouse' => ':id']) }}";
                    url = url.replace(':id', id);
                    formData.append('_method', 'PATCH');
                }

                formSubmitLoading( true );
                submitForm(url, formData, 'modal-create');
            }

            function updateData() {
                // if ($('#ename').val() == null || $('#ename').val() == "") {
                //     $('.invalid.ename').html('Please enter name');
                //     return false;
                // }
                // url = "{{ route('warehouse.update', ':id') }}";
                // url = url.replace(':id', $('#eid').val());
                // formdata = new FormData();
                // formdata.append('_token', '{{ csrf_token() }}');
                // formdata.append('name', $('#ename').val());
                // formdata.append('eid', $('#eid').val());
                // submitData(url, formdata);
            }

        </script>
    @endpush

    @include('admin.warehouse.warehouse.partials.create-modal')
@endsection
