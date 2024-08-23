@extends('adminlte::page')
@php $pagename = 'จัดการบทความ'; @endphp
@section('title', $pagename)
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-newspaper text-muted text-danger mr-2"></i> {{ $pagename }}
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

                @if (Auth::user()->hasAnyPermission(['*', 'all article', 'create article']))
                    <div class="text-right">
                        <a href="{{ route('article.create') }}" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2"><i
                                class="fas fa-plus mr-2"></i> {{ __('home.add') }}</a>
                    </div>
                @endif


                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" style="width: 10%">{{ __('article.number') }}</th>
                            <th class="text-center">{{ __('article.title_th') }}</th>
                            <th class="text-center">{{ __('article.title_en') }}</th>
                            <th class="text-center">{{ __('article.images') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('article.status') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('article.sort') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('article.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])

@push('js')
    <script>
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
                        targets: [0, 3, 4, 5, 6]
                    },
                    {
                        orderable: false,
                        targets: [3, 4, 5, 6]
                    },
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'name_th'
                    },
                    {
                        data: 'name_en'
                    },
                    {
                        data: 'img',
                        searchable: false
                    },
                    {
                        data: 'publish'
                    },
                    {
                        data: 'sorting'
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
    </script>
@endpush
@endsection
