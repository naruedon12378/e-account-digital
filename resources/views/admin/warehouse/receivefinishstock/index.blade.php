@extends('adminlte::page')
@php($pagename = 'Receive Finish Stock')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>
@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    @include('components.template.common-buttons', [
        'permissions' => ['*', 'all issue_requisition', 'create issue_requisition'],
        'import' => [
            'url' => null,
            'isActive' => false,
        ],
        'export' => [
            'url' => null,
            'isActive' => false,
        ],
        'new' => [
            'url' => 'warehouse/receivefinishstock/create',
            'id' => 'btnNewItem',
            'label' => 'Create Receive Finish Stock'
        ],
        'print' => [
            'url' => null,
            'isActive' => false,
        ]
    ])
    <x-index.card>
        @include('components.index.nav-tabs', $tabs)
        <div class="mb-3">
            <form id="frmIndex" class="form-inline" action="{{ route('receivefinishstock.index') }}">
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
                'company',
                'receipt_document_code',
                'company_address',
                'created_date',
                'issue_date',
                'status',
                'actions',
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
                        defaultContent: '-',
                        data: 'company_name'
                    },
                    {
                        defaultContent: '-',
                        data: 'receipt_document_code'
                    },
                    {
                        defaultContent: '-',
                        data: 'company_address'
                    },
         {
                        defaultContent: '-',
                        data: 'created_at'
                    },
                    {
                        defaultContent: '-',
                        data : 'isActive'
                    },
                    {
                        defaultContent: '-',
                        data: 'status'
                    },
                    {
                        data: 'action'
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
