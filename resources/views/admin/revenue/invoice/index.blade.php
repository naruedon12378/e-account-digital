@extends('adminlte::page')
@php($pagename = 'Invoice')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    @include('components.template.common-buttons', [
        'permissions' => ['*', 'all invoice', 'create invoice'],
        'import' => [
            'url' => null,
            'isActive' => false,
        ],
        'export' => [
            'url' => null,
            'isActive' => false,
        ],
        'new' => [
            'url' => 'revenue/invoices/create',
            'id' => 'btnNewItem',
            'label' => 'Create Invoice',
        ],
        'print' => [
            'url' => null,
            'isActive' => false,
        ],
    ])

    <x-index.card>
        @include('components.index.nav-tabs', $tabs)
        <div class="mb-3">
            <form id="frmIndex" class="form-inline" action="{{ route('invoices.index') }}">
                <input type="hidden" name="status" value="{{ $status }}">

                <label for="issue_date">Issue Date:</label>
                <x-daterangepicker class="mx-2" name="issue_date" :from="$fromDate" :to="$toDate"></x-daterangepicker>

                <x-button type="submit" class="secondary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </x-button>
            </form>
        </div>

        @include('components.index.datatable', [
            'columns' => [
                'Doc No.',
                'Customer',
                'Issue Date',
                'Due Date',
                'Net Amount',
                'Status',
                'Action',
            ],
            'file' => 'invoice',
            'id' => 'table',
            'class' => '',
        ])
    </x-index.card>

    @push('js')
        <script>
            $(document).ready(function() {
                const columns = [{
                        data: 'id'
                    },
                    {
                        data: 'doc_number'
                    },
                    {
                        data: 'customer_id'
                    },
                    {
                        data: 'issue_date'
                    },
                    {
                        data: 'due_date'
                    },
                    {
                        data: 'grand_total'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'action'
                    }
                ];
                dataTable(columns);
            });

            $(document).on('click', '#tabBar', function() {
                let para = $(this).attr('data-id');
                $('#frmIndex input[name="status"]').val(para);
                $('#frmIndex').submit();
            });
        </script>
    @endpush
@endsection
