@extends('adminlte::page')
@php $pagename = 'จัดการข้อมูลสมาชิก'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-user text-muted mr-2"></i> {{ $pagename }}
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

                <div class="text-right">
                    @if (Auth::user()->hasAnyPermission(['*', 'all member_history', 'create member_history']))
                        <a href="{{ route('member_history.index') }}" class="btn btn-outline-secondary mb-2"><i
                                class="fas fa-history mr-2"></i>
                            {{ __('member.member_history') }}</a>
                    @endif
                    @if (Auth::user()->hasAnyPermission(['*', 'all member', 'create member']))
                        <a href="{{ route('member.create') }}" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2"><i
                                class="fas fa-plus mr-2"></i>
                            {{ __('home.add') }}</a>
                    @endif
                </div>

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" style="width: 10%">{{ __('member.number') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('member.member_code') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('member.image') }}</th>
                            <th class="text-center">{{ __('member.fullname') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('member.role') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('member.phone_number') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('member.registration_date') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('member.actions') }}</th>
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
                            targets: [0, 2, 5, 6, 7]
                        },
                        {
                            orderable: false,
                            targets: [1, 4, 5, 6, 7]
                        },
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'user_code'
                        },
                        {
                            data: 'img',
                            orderable: false
                        },
                        {
                            data: 'fullname'
                        },
                        {
                            data: 'role'
                        },
                        {
                            data: 'phone'
                        },
                        {
                            data: 'created_at'
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
                showimg.src = "{{ asset('images/no-image.jpg') }}";
                $("#form")[0].reset();
            })

            $('#modal-edit').on('hidden.bs.modal', function(event) {
                showimg.src = "{{ asset('images/no-image.jpg') }}";
                $("#form")[0].reset();
            })

            $('.btnReset').on('click', function(event) {
                showimg.src = "https://placehold.co/650x320";
            })

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
@endsection
