@extends('adminlte::page')
@php($pagename = 'จัดการหน่วย')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    @include('components.template.common-buttons', [
        'permissions' => ['*', 'all unit', 'create unit'],
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
            'label' => 'Create Unit'
        ],
        'print' => [
            'url' => null,
            'isActive' => false,
        ]
    ])

    <x-index.card>
        @include('components.index.nav-tabs', $tabs)
        @include('components.index.datatable', [
            'columns' => ['code', 'type', 'unit_name_th', 'unit_name_en', 'status', 'actions'],
            'file' => 'unit',
            'id' => 'table',
            'class' => '',
        ])
    </x-index.card>

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
                    columns: [{
                            data: 'code'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'name_th'
                        },
                        {
                            data: 'name_en'
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
                            targets: [4, 5]
                        },
                        {
                            orderable: false,
                            targets: [4, 5]
                        },
                    ],
                    "dom": 'rtip',
                });

                $('#custom-search-input').keyup(function() {
                    table.search($(this).val()).draw();
                })

                formSubmitLoading( false );
                $('#btnNewItem').on('click', function() {
                    $('#staticBackdropLabel').html("{{ __('home.add') }}");
                    createModal('addUnitModal');
                });

                $('#addUnitModal').on('hidden.bs.modal', function(event) {
                    formSubmitLoading( false );
                    $("#form")[0].reset();
                    $('.invalid').html('');

                })

                $(document).on('click', '.js-edit', function() {
                    $('#staticBackdropLabel').html("{{ __('home.edit') }}");
                    formLoading(true);
                    const id = $(this).attr('data-id');
                    $.get('unit/' + id + '/edit', function(unit) {
                        formLoading(false);
                        for (const key in unit) {
                            if (key == "type") {
                                $('#addUnitModal #form #' + unit[key]).prop('checked', true);
                            } else {
                                $('#addUnitModal #form #' + key).val(unit[key]);
                            }
                        }
                    });
                    $('#addUnitModal #title').text("Edit");
                    $('#addUnitModal').modal('show');
                });
            });

            $('#addUnitModal #btnSubmit').on('click', function() {

                if( !validationData() )
                    return;

                const formData = new FormData($('#form')[0]);
                let url = "{{ route('unit.store') }}";
                const id = $('#id').val()
                if( id && id>0 ){
                    url = "{{ route('unit.update', ['unit' => ':id']) }}";
                    url = url.replace(':id', id);
                    formData.append('_method', 'patch');
                }

                formSubmitLoading(true);
                submitForm(url, formData, "addUnitModal");
            });

            $(document).on('click','.nav .nav-link', function(){
                let para = $(this).attr('data-id');
                let route = "{{ route('units.index') }}";
                $('#frmSearch').attr('action', route);
                $('#frmSearch input[name="type"]').val(para);
                $('#frmSearch').submit();
            });

            function validationData(){

                let status = true;
                if ($('#code').val() == null || $('#code').val() == "") {
                    $('.invalid.code').html('กรุณาใส่หรัส');
                    status =  false;
                }

                if ($('#name_th').val() == null || $('#name_th').val() == "") {
                    $('.invalid.name_th').html('กรุณาใส่ชื่อภาษาไทย');
                    status =  false;
                }

                if ($('#name_en').val() == null || $('#name_en').val() == "") {
                    $('.invalid.name_en').html('กรุณาใส่ชื่อภาษาอังกฤษ');
                    status =  false;
                }

                return status;
            }

        </script>
    @endpush

    @include('admin.unit.partials.create-modal')
@endsection
