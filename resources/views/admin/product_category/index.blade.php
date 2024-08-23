@extends('adminlte::page')
@php $pagename = 'จัดการกลุ่มสินค้า'; @endphp
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

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" style="width: 10%">{{ __('product_category.code') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('product_category.image') }}</th>
                            <th class="text-center">{{ __('product_category.name_th') }}</th>
                            <th class="text-center">{{ __('product_category.name_en') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('product_category.product_type_name') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('product_category.status') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('product_category.actions') }}</th>
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
            // $('input[name="iswColor"]').bootstrapSwitch('state', true, true);
            var sts_email;
            var sts;
            $('#btn_submit_loading').hide();

            let table;
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
                            targets: [0, 1, 5]
                        },
                        {
                            orderable: false,
                            targets: [0, 1, 5]
                        },
                    ],
                    columns: [
                        // {
                        //     data: 'DT_RowIndex',
                        //     name: 'id'
                        // },
                        {
                            data: 'code',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'image',
                            orderable: false
                        },
                        {
                            data: 'name_th'
                        },
                        {
                            data: 'name_en',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'product_type_name',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'isActive'
                        },
                        {
                            data: 'action'
                        },
                    ],
                    order: [
                        [2, 'asc']
                    ],
                    "dom": 'rtip',
                });
            });

            formSubmitLoading( false );
            $('#btnNewItem').on('click', function() {
                $('#staticBackdropLabel .label').html("{{ __('home.add') }}");
                showimg.src = "https://placehold.co/300x300";
            });

            $(document).on('click', '.js-edit', function() {
                formLoading(true);
                $('#staticBackdropLabel .label').html("{{ __('home.edit') }}");
                showimg.src = "https://placehold.co/300x300";
                $('#modal-create').modal('show');
                const id = $(this).attr('data-id');
                $.get('productcategory/' + id + '/edit', function(resp) {

                    for (const key in resp.product_category) {
                        if( key == 'is_active'){
                            $('#modal-create #form #isactive_' + resp.product_category[key]).prop('checked', true);
                        }
                        else  if( key == 'cost_calculation_type'){
                            $('#modal-create #form #cost_' + resp.product_category[key]).prop('checked', true);
                        }
                        else{
                            $('#modal-create #form #' + key).val(resp.product_category[key]);
                        }
                    }

                    if (resp.image) {
                        showimg.src = resp.image;
                    }

                    formLoading(false);
                });
                // $('#update_loading').hide();
            });

            //custom search datatable
            $('#custom-search-input').keyup(function() {
                table.search($(this).val()).draw();
            })

            $('#modal-create').on('hidden.bs.modal', function(event) {

                formSubmitLoading( false );

                showimg.src = "https://placehold.co/300x300";
                $("#form")[0].reset();
                $('.invalid').html('');
                //clear select
                $("#product_type_id").select2(null);
            })

            $('.btnReset').on('click', function(event) {
                showimg.src = "https://placehold.co/650x320";
            })

            //Preview img
            $('#showimg').click(function() {
                $('#img').trigger('click');
            });

            function previewImg(id) {
                const [file] = id.files
                if (file) {
                    if (id.id === "img") {
                        showimg.src = URL.createObjectURL(file);
                    } else if (id.id === 'eimg') {
                        eshowimg.src = URL.createObjectURL(file);
                    }
                }
            }

            //storeData
            function storeData() {

                if( !validationData() )
                    return;

                let url = "{{ route('productcategory.store') }}";
                let formData = new FormData($('#form')[0]);

                const id = $('#id').val()
                if( id && id>0 ){
                    url = "{{ route('productcategory.update', ['productcategory' => ':id']) }}";
                    url = url.replace(':id', id);
                    formData.append('_method', 'patch');
                }

                formSubmitLoading( true );
                submitForm(url, formData, 'modal-create');
            }

            function validationData(){

                $('.invalid').html('');

                let status = true;
                if ($('#name_th').val() == null || $('#name_th').val() == "") {
                    // toastr.error('กรุณาใส่ชื่อภาษาไทย');
                    $('.invalid.name_th').html('กรุณาใส่ชื่อภาษาไทย');
                    status = false;
                }

                if ( !$('#product_type_id').val()) {
                    // toastr.error('กรุณาเลือกประเภทสินค้า');
                    $('.invalid.product_type_id').html('กรุณาเลือกประเภทสินค้า');
                    status = false;
                }

                return status;
            }
        </script>
    @endpush

    @include('admin.product_category.partials.create-modal')
@endsection
