@extends('adminlte::page')
@php $pagename = 'ตั่งค่าหน่วยนับย่อย'; @endphp
@section('title', setting('title') . ' | ' . $pagename)

@section('content')
    @include('vendor.adminlte.partials.common.breadcrumb', ['pagename' => $pagename])
    <!-- @include('vendor.adminlte.partials.common.common-buttons', [
        'permissions' => ['*', 'all unit_set', 'create unit_set'],
        'import' => [
            'url' => null,
            'isActive' => false,
        ],
        'export' => [
            'url' => null,
            'isActive' => true,
        ],
        'new' => [
            'url' => null,
            'id' => 'btnNewItem',
        ],
    ]) -->

    <div class="card shadow-custom">
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

            @if (Auth::user()->hasAnyPermission(['*', 'all unit_set', 'create unit_set']))
                <div class="text-right">
                    <a href="{{ route('unitset.create') }}" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2"  id="btnNewItem"><i class="fas fa-plus mr-2"></i> เพิ่มข้อมูล</a>
                </div>
            @endif

            <table id="table" class="table table-hover">
                <thead>
                    <tr>
                        <th>{{ __('unit_set.code') }}</th>
                        <th>{{ __('unit_set.name_th') }}</th>
                        <th>{{ __('unit_set.name_en') }}</th>
                        <th>{{ __('unit_set.unit_child') }}</th>
                        <th>{{ __('unit_set.status') }}</th>
                        <th>{{ __('unit_set.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @push('js')
        <script>
            var table;
            $(document).ready(function() {
                table = $('#table').DataTable({
                    pageLength: 10,
                    responsive: true,
                    processing: false,
                    scrollX: true,
                    scrollCollapse: true,
                    serverSide: true,
                    // language: {
                    //     url: "{{ asset('plugins/datatable-th.json') }}",
                    // },
                    ajax: "",
                    columns: [
                        {
                            data: 'unit.code',
                            defaultContent: "<i>-</i>"
                        },
                        {
                            data: 'unit.name_th'
                        },
                        {
                            data: 'unit.name_en',
                            defaultContent: "<i>-</i>"
                        },
                        {
                            data: 'children_count',
                            defaultContent: "<i>-</i>"
                        },
                        {
                            data: 'isActive'
                        },
                        {
                            data: 'action'
                        },
                    ],
                    order: [
                        [1, 'asc']
                    ],
                    columnDefs: [{
                            className: 'text-center',
                            targets: [0, 3, 4]
                        },
                        {
                            orderable: false,
                            targets: [3, 4]
                        },
                    ],
                    "dom": 'rtip',
                });

                // formSubmitLoading( false );
                // $('#btnNewItem').on('click', function() {
                //     $('#staticBackdropLabel .label').html("{{ __('home.add') }}");
                //     formSubmitLoading( false );
                //     createModal('addProductTypeModal');
                // });

                // $(document).on('click', '.js-edit', function() {

                //     $('#addProductTypeModal').modal('show');
                //     $('#staticBackdropLabel .label').html("{{ __('home.edit') }}");
                //     formSubmitLoading( true );
                //     const id = $(this).attr('data-id');
                //     $.get('producttype/' + id + '/edit', function(unit_sets) {
                //         formSubmitLoading( false );
                //         for (const key in unit_sets) {
                //             // console.log('unit_sets' , key, unit_sets[key]);
                //             if (key == "type") {
                //                 $('#addProductTypeModal #form #' + unit_sets[key]).prop('checked', true);
                //             } else {
                //                 $('#addProductTypeModal #form #' + key).val(unit_sets[key]);
                //             }
                //         }
                //     });
                // });
            });

            $('#custom-search-input').keyup(function() {
                table.search($(this).val()).draw();
            })

            // $('#addProductTypeModal #btnSubmit').on('click', function() {

            //     if ($('#name_th').val() == null || $('#name_th').val() == "") {
            //         $('.invalid.name_th').html('กรุณาใส่ชื่อภาษาไทย');
            //         return false;
            //     }

            //     let url = "{{ route('productcategory.store') }}";
            //     let formData = new FormData($('#form')[0]);

            //     const id = $('#id').val()
            //     if( id && id>0 ){
            //         url = "{{ route('producttype.update', ['producttype' => ':id']) }}";
            //         url = url.replace(':id', id);
            //         formData.append('_method', 'patch');
            //     }

            //     formSubmitLoading( true );
            //     submitForm(url, formData, "addProductTypeModal");
            // });
        </script>
    @endpush

    @include('admin.unit_set.partials.create-modal')
@endsection
