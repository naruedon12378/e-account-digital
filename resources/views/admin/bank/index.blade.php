@extends('adminlte::page')
@php $pagename = 'จัดการธนาคาร'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-pen text-muted mr-2"></i> {{ $pagename }}
        </div>

        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
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

                @if (Auth::user()->hasAnyPermission(['*', 'all bank', 'create bank']))
                    <div class="text-right">
                        <a href="" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2" data-toggle="modal"
                            data-target="#modal-create"><i class="fas fa-plus mr-2"></i> {{ __('home.add') }}</a>
                    </div>
                @endif

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" style="width: 10%">{{ __('bank.number') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('bank.logo') }}</th>
                            <th class="text-center">{{ __('bank.bank_name_th') }}</th>
                            <th class="text-center">{{ __('bank.bank_name_en') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('bank.status') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('bank.actions') }}</th>
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
                            targets: [0, 1, 4, 5]
                        },
                        {
                            orderable: false,
                            targets: [1, 4, 5]
                        },
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'img'
                        },
                        {
                            data: 'name_th'
                        },
                        {
                            data: 'name_en'
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


            $('#modal-create').on('hidden.bs.modal', function(event) {
                showimg.src = "https://placehold.co/300x300";
                $("#form")[0].reset();
            })

            $('#modal-edit').on('hidden.bs.modal', function(event) {
                eshowimg.src = "https://placehold.co/300x300";
                $("#form")[0].reset();
            })

            $('.btnReset').on('click', function(event) {
                showimg.src = "https://placehold.co/300x300";
                eshowimg.src = "https://placehold.co/300x300";
            })

            //storeData
            function storeData() {
                if ($('#name_th').val() == null || $('#name_th').val() == "") {
                    toastr.error('กรุณาใส่ชื่อหัวข้อภาษาไทย');
                    return false;
                }

                if ($('#name_en').val() == null || $('#name_en').val() == "") {
                    toastr.error('กรุณาใส่ชื่อหัวข้อภาษาอังกฤษ');
                    return false;
                }

                url = "{{ route('bank.store') }}";

                formdata = new FormData();
                formdata.append('_token', '{{ csrf_token() }}');
                formdata.append('name_th', $('#name_th').val());
                formdata.append('name_en', $('#name_en').val());
                formdata.append('img', $('#img')[0].files[0]);

                submitData(url, formdata);
            }

            //requestData
            function requestData(response) {
                $('#eid').val(response.bank.id);
                $('#ename_th').val(response.bank.name_th);
                $('#ename_en').val(response.bank.name_en);

                if (response.image) {
                    eshowimg.src = response.image;
                } else {
                    eshowimg.src = "https://placehold.co/300x300";
                }

                $('#modal-edit').modal('show');
            }


            //updateData
            function updateData() {
                if ($('#ename_th').val() == null || $('#ename_th').val() == "") {
                    toastr.error('กรุณาใส่ชื่อหัวข้อภาษาไทย');
                    return false;
                }

                if ($('#ename_en').val() == null || $('#ename_en').val() == "") {
                    toastr.error('กรุณาใส่ชื่อหัวข้อภาษาอังกฤษ');
                    return false;
                }

                id = $('#eid').val();
                // url = '{{ route('bank.update', ['bank' => ':id']) }}';
                // url = url.replace(':id', id);
                url = '{{ route('bank.update') }}';

                eformdata = new FormData();
                eformdata.append('_token', '{{ csrf_token() }}');
                eformdata.append('name_th', $('#ename_th').val());
                eformdata.append('name_en', $('#ename_en').val());
                eformdata.append('img', $('#eimg')[0].files[0]);
                eformdata.append('id', id);

                submitData(url, eformdata);
            }

            //Preview img
            $('#showimg').click(function() {
                $('#img').trigger('click');
            });

            $('#eshowimg').click(function() {
                $('#eimg').trigger('click');
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
        </script>
    @endpush

    @include('admin.bank.partials.create-modal')
    @include('admin.bank.partials.edit-modal')
@endsection
