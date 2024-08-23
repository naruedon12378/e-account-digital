@extends('adminlte::page')
@php($pagename = 'Beginning Balance')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>
@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    @include('components.template.common-buttons', [
        'permissions' => ['*', 'all beginningbalance', 'create beginningbalance'],
        'import' => [
            'url' => null,
            'isActive' => false,
        ],
        'export' => [
            'url' => null,
            'isActive' => false,
        ],
        'new' => [
            'url' => 'warehouse/beginningbalance/create',
            'id' => 'btnNewItem',
            'label' => 'Create Begining Balance'
        ],
        'print' => [
            'url' => null,
            'isActive' => false,
        ]
    ])
    <x-index.card>
        @include('components.index.nav-tabs', $tabs)
        <div class="mb-3">
            <form id="frmIndex" class="form-inline" action="{{ route('beginningbalance.index') }}">
                <input type="hidden" name="status" value="{{ $status }}">

                <label for="issue_date">Issue Date:</label>
                <x-daterangepicker class="mx-2" name="issue_date" :from="$fromDate" :to="$toDate"></x-daterangepicker>

                <x-button type="submit" class="secondary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </x-button>
            </form>
        </div>
        @include('components.warehouse.datatable', [
            'columns' => [
                'code',
                'company',
                'company_address',
                'net_amount',
                // 'created_date',
                'issue_date',
                'status',
                // 'actions',
            ],
            'file' => "beginning_balance",
            'id' => 'table',
            'class' => '',
        ])
    </x-index.card>
    @push('js')
        <script>
            $(document).ready(function() {
                const columns = [
                    {
                        data: 'blank'
                    },
                    {
                        data: 'action'
                    },
                    {
                        defaultContent: '-',
                        data: 'company_name'
                    },
                    {
                        defaultContent: '-',
                        data: 'company_address'
                    },
                    {   defaultContent: '-',
                        data: 'total_price'
                    },
                    {
                        defaultContent: '-',
                        data: 'created_date'
                    },
                    // {
                    //     defaultContent: '-',
                    //     data : 'isActive'
                    // },
                    {
                        defaultContent: '-',
                        data: 'status'
                    }
                ];
                dataTable(columns);
            });
            $(document).on('click', '#tabBar .nav-link', function() {
                let para = $(this).attr('data-id');
                console.log(para);
                $('#frmIndex input[name="status"]').val(para);
                $('#frmIndex').submit();
            });
        </script>
    @endpush
@endsection
