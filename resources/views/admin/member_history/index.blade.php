@extends('adminlte::page')
@php $pagename = 'ประวัติสมาชิก'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-history text-muted mr-2"></i> {{ $pagename }}
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
                    @if (Auth::user()->hasAnyPermission(['*', 'all member', 'view member']))
                        <a href="{{ route('member.index') }}" class="btn btn-outline-secondary mb-2"><i
                                class="fas fa-arrow-left mr-2"></i>
                            {{ __('member.back_to_member_page') }}</a>
                    @endif
                </div>

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" style="width: 10%">{{ __('member.number') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('member.image') }}</th>
                            <th class="text-center">{{ __('member.fullname') }}</th>
                            <th class="text-center">{{ __('member.phone_number') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('member.registration_date') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('member.disabled_date') }}</th>
                            {{-- <th class="text-center">สถานะ</th> --}}
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
            var table;
            $(document).ready(function() {
                table = $('#table').DataTable({
                    pageLength: 10,
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
                            targets: [0, 1, 3, 4, 5, 6]
                        },
                        {
                            orderable: false,
                            targets: [1, 2, 3, 4, 5, 6]
                        },
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'img',
                            orderable: false
                        },
                        {
                            data: 'fullname'
                        },
                        {
                            data: 'phone'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'updated_at'
                        },
                        // {
                        //     data: 'status'
                        // },
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

            function recoveryData(url) {
                Swal.fire({
                    title: 'ต้องการกู้ข้อมูลใช่หรือไม่',
                    text: 'หากกู้ข้อมูล ข้อมูลจะถูกย้ายไปอยู่ที่หน้าจัดการสมาชิก',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('home.ok') }}',
                    cancelButtonText: '{{ __('home.close') }}',
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
@endsection
